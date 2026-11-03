<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    public function index(Request $request, JobListing $job)
    {
        abort_unless($job->company_id === $request->user()->company?->id, 403);

        $applications = $job->applications()->with('candidate')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(15)->withQueryString();

        return view('employer.applicants', compact('job', 'applications'));
    }

    public function update(Request $request, Application $application)
    {
        $this->authorizeApplication($application);

        $data = $request->validate(['status' => ['required', Rule::in(Application::STATUSES)]]);
        $application->update($data);

        return back()->with('success', $application->candidate->name.' marked as '.$data['status'].'.');
    }

    public function resume(Application $application)
    {
        $this->authorizeApplication($application);

        abort_unless(Storage::disk('local')->exists($application->resume_path), 404);

        $ext = pathinfo($application->resume_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download(
            $application->resume_path,
            str($application->candidate->name)->slug().'-resume.'.$ext
        );
    }

    private function authorizeApplication(Application $application): void
    {
        abort_unless(
            $application->job->company_id === auth()->user()->company?->id,
            403
        );
    }
}
