<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount('tutorials')->get();
        $totalTutorials = Tutorial::published()->count();
        $totalBranches = Branch::count();

        return view('home', compact('branches', 'totalTutorials', 'totalBranches'));
    }
}