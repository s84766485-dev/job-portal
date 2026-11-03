<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::with('company', 'category')
            ->published()
            ->filter($request->only('q', 'location', 'category', 'type', 'level'))
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('jobs.index', [
            'jobs' => $jobs,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(JobListing $job)
    {
        $user = auth()->user();
        $isOwner = $user && ($user->isAdmin() || $user->company?->id === $job->company_id);

        abort_unless($job->isOpen() || $isOwner, 404);

        $job->load('company', 'category');

        $application = $user?->isCandidate()
            ? $user->applications()->where('job_listing_id', $job->id)->first()
            : null;

        $related = JobListing::with('company')->published()
            ->where('category_id', $job->category_id)
            ->whereKeyNot($job->id)->latest()->take(3)->get();

        return view('jobs.show', compact('job', 'application', 'related'));
    }
}
