<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('family')->orderBy('name')->get()->groupBy('family');
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $families = Tag::distinct()->pluck('family')->filter()->toArray();
        return view('admin.tags.create', compact('families'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags',
            'family' => 'required|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $families = Tag::distinct()->pluck('family')->filter()->toArray();
        return view('admin.tags.edit', compact('tag', 'families'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $tag->id,
            'family' => 'required|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if ($tag->tutorials()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'Impossible de supprimer ce tag car il est utilisé par des tutoriels.');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag supprimé avec succès !');
    }
}