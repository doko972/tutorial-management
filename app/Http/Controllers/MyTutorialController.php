<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\Tag;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TutorialPublished;

class MyTutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tutorials = Tutorial::with(['branch', 'tags'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('my-tutorials.index', compact('tutorials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('family')->orderBy('name')->get();
        $branches = Branch::with('children')->whereNull('parent_id')->get();
        
        return view('my-tutorials.create', compact('tags', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'file_type' => 'required|in:document,pdf,video,link,text',
            'branch_id' => 'required|exists:branches,id',
            'video_url' => 'nullable|url|max:500',
            'file' => 'nullable|file|max:51200', // 50MB max
            'thumbnail' => 'nullable|image|max:2048', // 2MB max
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_published' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        // $validated['branch_id'] = auth()->user()->branch_id;
        $validated['slug'] = Str::slug($validated['title']);

        // Gestion du fichier
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tutorials', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['file_size'] = $file->getSize();
        }

        // Gestion de la miniature
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::slug(pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnailName, 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        $validated['published_at'] = $validated['is_published'] ?? false ? now() : null;

        $tutorial = Tutorial::create($validated);

        // Attacher les tags
        if ($request->has('tags')) {
            $tutorial->tags()->attach($request->tags);
        }

        // Envoyer une notification aux utilisateurs de la même branche
        if ($tutorial->is_published) {
            $users = User::where('branch_id', $tutorial->branch_id)
                ->where('id', '!=', auth()->id())
                ->get();

            Notification::send($users, new TutorialPublished($tutorial));
        }

        return redirect()->route('my-tutorials.index')
            ->with('success', 'Tutoriel créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tutorial $myTutorial)
    {
        $this->authorize('update', $myTutorial);
        
        $tags = Tag::orderBy('family')->orderBy('name')->get();
        $branches = Branch::with('children')->whereNull('parent_id')->get();
        
        return view('my-tutorials.edit', compact('myTutorial', 'tags', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tutorial $myTutorial)
    {
        $this->authorize('update', $myTutorial);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'file_type' => 'required|in:document,pdf,video,link,text',
            'branch_id' => 'required|exists:branches,id', 
            'file' => 'nullable|file|max:102400',
            'video_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Gestion du nouveau fichier
        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($myTutorial->file_path) {
                Storage::disk('public')->delete($myTutorial->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tutorials', $filename, 'public');
            $validated['file_path'] = $path;
            $validated['file_size'] = $file->getSize();
        }

        // Gestion de la nouvelle miniature
        if ($request->hasFile('thumbnail')) {
            // Supprimer l'ancienne miniature
            if ($myTutorial->thumbnail) {
                Storage::disk('public')->delete($myTutorial->thumbnail);
            }

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::slug(pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnailName, 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        $validated['published_at'] = $validated['is_published'] ?? false ? ($myTutorial->published_at ?? now()) : null;

        $myTutorial->update($validated);

        // Synchroniser les tags
        if ($request->has('tags')) {
            $myTutorial->tags()->sync($request->tags);
        } else {
            $myTutorial->tags()->detach();
        }

        // Envoyer une notification si le tutoriel vient d'être publié
        if ($validated['is_published'] && !$myTutorial->is_published) {
            $users = User::where('branch_id', $myTutorial->branch_id)
                ->where('id', '!=', auth()->id())
                ->get();

            Notification::send($users, new TutorialPublished($myTutorial));
        }

        return redirect()->route('my-tutorials.index')
            ->with('success', 'Tutoriel modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutorial $myTutorial)
    {
        $this->authorize('delete', $myTutorial);

        // Supprimer les fichiers
        if ($myTutorial->file_path) {
            Storage::disk('public')->delete($myTutorial->file_path);
        }
        if ($myTutorial->thumbnail) {
            Storage::disk('public')->delete($myTutorial->thumbnail);
        }

        $myTutorial->delete();

        return redirect()->route('my-tutorials.index')
            ->with('success', 'Tutoriel supprimé avec succès !');
    }
}