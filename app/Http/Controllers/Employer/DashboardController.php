<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $jobIds = $company->jobs()->pluck('id');

        $stats = [
            'jobs'        => $company->jobs()->count(),
            'published'   => $company->jobs()->where('status', 'published')->count(),
            'applicants'  => Application::whereIn('job_listing_id', $jobIds)->count(),
            'shortlisted' => Application::whereIn('job_listing_id', $jobIds)->where('status', 'shortlisted')->count(),
        ];

        $recent = Application::with('candidate', 'job')
            ->whereIn('job_listing_id', $jobIds)->latest()->take(6)->get();

        return view('employer.dashboard', compact('company', 'stats', 'recent'));
    }
}
