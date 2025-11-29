<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::whereNull('parent_id')
            ->withCount(['users', 'tutorials'])
            ->with([
                'children' => function ($query) {
                    $query->withCount(['users', 'tutorials']);
                }
            ])
            ->get();
        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentBranches = Branch::whereNull('parent_id')->get();
        return view('admin.branches.create', compact('parentBranches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:branches',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:branches,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branche créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $branch->load(['users', 'tutorials']);
        return view('admin.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $parentBranches = Branch::whereNull('parent_id')->where('id', '!=', $branch->id)->get();
        return view('admin.branches.edit', compact('branch', 'parentBranches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:branches,name,' . $branch->id,
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:branches,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branche modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        // Vérifier s'il y a des utilisateurs ou tutoriels liés
        if ($branch->users()->count() > 0 || $branch->tutorials()->count() > 0) {
            return redirect()->route('admin.branches.index')
                ->with('error', 'Impossible de supprimer cette branche car elle contient des utilisateurs ou des tutoriels.');
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branche supprimée avec succès !');
    }
}