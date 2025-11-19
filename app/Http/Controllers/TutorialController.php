<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\Branch;
use App\Models\TutorialView;
use Illuminate\Http\Request;
use App\Models\Tag;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tutorial::with(['branch', 'author', 'tags'])
            ->published()
            ->latest();

        if ($request->has('branch') && $request->branch) {
            $branchId = $request->branch;
            $branch = Branch::find($branchId);

            if ($branch) {
                // Si c'est une branche parente, inclure aussi les sous-branches
                if ($branch->children()->count() > 0) {
                    $childrenIds = $branch->children()->pluck('id')->toArray();
                    $query->whereIn('branch_id', array_merge([$branchId], $childrenIds));
                } else {
                    // Sinon, juste la branche sélectionnée
                    $query->where('branch_id', $branchId);
                }
            }
        }

        // Filtrer par type de fichier
        if ($request->has('type') && $request->type) {
            $query->where('file_type', $request->type);
        }

        // Filtrer par tag
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // Filtrer par date
        if ($request->has('date') && $request->date) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        // Recherche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Tri
        if ($request->has('sort') && $request->sort) {
            switch ($request->sort) {
                case 'popular':
                    $query->orderBy('views_count', 'desc');
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'title':
                    $query->orderBy('title', 'asc');
                    break;
                default:
                    $query->latest();
            }
        }

        $tutorials = $query->paginate(12)->withQueryString();
        $branches = Branch::withCount('tutorials')->get();
        $tags = Tag::withCount('tutorials')->orderBy('name')->get();

        // Compteur de résultats
        $totalResults = $tutorials->total();
        $hasFilters = $request->hasAny(['search', 'branch', 'type', 'tag', 'date', 'sort']);

        return view('tutorials.index', compact('tutorials', 'branches', 'tags', 'totalResults', 'hasFilters'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutorial $tutorial)
    {
        $this->authorize('view', $tutorial);

        // Marquer la notification comme lue si elle existe
        if (auth()->check() && request()->has('notification')) {
            $notification = auth()->user()->notifications()->find(request('notification'));
            if ($notification) {
                $notification->markAsRead();
            }
        }

        // Enregistrer la vue
        TutorialView::create([
            'tutorial_id' => $tutorial->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
        ]);

        // Incrémenter le compteur de vues
        $tutorial->increment('views_count');

        $tutorial->load(['branch', 'author', 'tags']);

        // Tutoriels similaires
        $relatedTutorials = Tutorial::published()
            ->where('branch_id', $tutorial->branch_id)
            ->where('id', '!=', $tutorial->id)
            ->limit(3)
            ->get();

        return view('tutorials.show', compact('tutorial', 'relatedTutorials'));
    }
}