<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function index()
    {
        $jobs = auth()->user()->company->jobs()
            ->withCount('applications')->latest()->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create', [
            'job' => new JobListing(['type' => 'Full-time', 'level' => 'Mid', 'status' => 'published']),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']).'-'.Str::lower(Str::random(5));

        $job = $request->user()->company->jobs()->create($data);

        return redirect()->route('employer.jobs.index')
            ->with('success', '"'.$job->title.'" saved as '.$job->status.'.');
    }

    public function edit(JobListing $job)
    {
        $this->own($job);

        return view('employer.jobs.edit', [
            'job' => $job,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, JobListing $job)
    {
        $this->own($job);
        $job->update($this->validated($request));

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated.');
    }

    public function destroy(JobListing $job)
    {
        $this->own($job);
        $job->delete();

        return back()->with('success', 'Job deleted.');
    }

    private function own(JobListing $job): void
    {
        abort_unless($job->company_id === auth()->user()->company?->id, 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string|max:10000',
            'requirements' => 'nullable|string|max:5000',
            'location' => 'required|string|max:120',
            'type' => ['required', Rule::in(JobListing::TYPES)],
            'level' => ['required', Rule::in(JobListing::LEVELS)],
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|gte:salary_min',
            'deadline' => 'nullable|date|after_or_equal:today',
            'status' => 'required|in:draft,published,closed',
        ]);
    }
}
