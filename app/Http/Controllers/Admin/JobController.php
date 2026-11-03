<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::with('company')->withCount('applications')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->q, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.jobs', compact('jobs'));
    }

    public function feature(JobListing $job)
    {
        $job->update(['is_featured' => ! $job->is_featured]);

        return back()->with('success', $job->is_featured ? 'Job is now featured.' : 'Job is no longer featured.');
    }

    public function status(Request $request, JobListing $job)
    {
        $data = $request->validate(['status' => 'required|in:draft,published,closed']);
        $job->update($data);

        return back()->with('success', 'Job status set to '.$data['status'].'.');
    }

    public function destroy(JobListing $job)
    {
        $job->delete();

        return back()->with('success', 'Job deleted.');
    }
}
