<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobListing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'candidates'   => User::where('role', 'candidate')->count(),
            'employers'    => User::where('role', 'employer')->count(),
            'jobs'         => JobListing::count(),
            'open_jobs'    => JobListing::published()->count(),
            'applications' => Application::count(),
        ];

        $latestUsers = User::latest()->take(6)->get();
        $latestJobs = JobListing::with('company')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestJobs'));
    }
}
