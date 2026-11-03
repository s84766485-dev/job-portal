<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobListing;

class HomeController extends Controller
{
    public function index()
    {
        $featured = JobListing::with('company', 'category')->published()
            ->where('is_featured', true)->latest()->take(4)->get();

        $latest = JobListing::with('company', 'category')->published()
            ->latest()->take(8)->get();

        $categories = Category::withCount(['jobs' => fn ($q) => $q->published()])
            ->orderByDesc('jobs_count')->take(8)->get();

        return view('home', compact('featured', 'latest', 'categories'));
    }

    /** Sends each role to its own landing page. */
    public function dashboard()
    {
        return match (auth()->user()->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'employer' => redirect()->route('employer.dashboard'),
            default    => redirect()->route('candidate.applications'),
        };
    }
}
