<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function store(Request $request, JobListing $job)
    {
        abort_unless($job->isOpen(), 404);

        $user = $request->user();

        if ($user->applications()->where('job_listing_id', $job->id)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $data = $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:4096',
            'cover_letter' => 'nullable|string|max:3000',
        ]);

        // Stored on the private "local" disk; only the employer or the candidate can download it.
        $path = $request->file('resume')->store('resumes', 'local');

        $user->applications()->create([
            'job_listing_id' => $job->id,
            'resume_path' => $path,
            'cover_letter' => $data['cover_letter'] ?? null,
        ]);

        return redirect()->route('candidate.applications')
            ->with('success', 'Application sent to '.$job->company->name.'.');
    }

    public function mine(Request $request)
    {
        $applications = $request->user()->applications()
            ->with('job.company')->latest()->paginate(10);

        return view('candidate.applications', compact('applications'));
    }

    public function withdraw(Request $request, Application $application)
    {
        abort_unless($application->user_id === $request->user()->id, 403);
        abort_unless($application->status === 'pending', 403, 'Only pending applications can be withdrawn.');

        Storage::disk('local')->delete($application->resume_path);
        $application->delete();

        return back()->with('success', 'Application withdrawn.');
    }
}
