@extends('layouts.app')
@section('title', 'My jobs')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="font-display text-3xl font-bold text-ink">My jobs</h1>
    <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">Post a job</a>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-sm text-slate-500">
            <tr><th class="p-4">Title</th><th class="p-4">Status</th><th class="p-4">Applicants</th><th class="p-4">Deadline</th><th class="p-4"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        @forelse ($jobs as $job)
            <tr>
                <td class="p-4"><a class="font-medium text-ink hover:text-teal" href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                    <div class="text-sm text-slate-500">{{ $job->location }} · {{ $job->type }}</div></td>
                <td class="p-4"><span class="rounded-full px-2.5 py-0.5 text-sm {{ $job->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($job->status === 'closed' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700') }}">{{ ucfirst($job->status) }}</span></td>
                <td class="p-4"><a class="text-teal font-medium" href="{{ route('employer.jobs.applicants', $job) }}">{{ $job->applications_count }}</a></td>
                <td class="p-4 text-slate-500">{{ $job->deadline?->format('j M Y') ?? '—' }}</td>
                <td class="p-4 text-right whitespace-nowrap">
                    <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-ghost !py-1 text-sm">Edit</a>
                    <form class="inline" method="POST" action="{{ route('employer.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job and all its applications?')">
                        @csrf @method('DELETE') <button class="btn btn-danger !py-1 text-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="p-10 text-center text-slate-500">You haven't posted a job yet. <a class="text-teal" href="{{ route('employer.jobs.create') }}">Post your first one</a>.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $jobs->links() }}</div>
@endsection
