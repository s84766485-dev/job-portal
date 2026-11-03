@extends('layouts.app')
@section('title', 'Employer dashboard')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h1 class="font-display text-3xl font-bold text-ink">{{ $company->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('employer.company.edit') }}" class="btn btn-ghost">Edit company</a>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">Post a job</a>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    @foreach (['jobs' => 'Jobs posted', 'published' => 'Live now', 'applicants' => 'Applications', 'shortlisted' => 'Shortlisted'] as $k => $label)
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <div class="font-display text-3xl font-bold text-ink">{{ $stats[$k] }}</div>
            <div class="text-sm text-slate-500">{{ $label }}</div>
        </div>
    @endforeach
</div>

<h2 class="font-display text-xl font-bold text-ink mb-3">Newest applications</h2>
<div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
    @forelse ($recent as $a)
        <a href="{{ route('employer.jobs.applicants', $a->job_listing_id) }}" class="flex items-center gap-4 p-4 hover:bg-slate-50">
            <div class="flex-1 min-w-0">
                <div class="font-medium text-ink">{{ $a->candidate->name }}</div>
                <div class="text-sm text-slate-500">applied for {{ $a->job->title }} · {{ $a->created_at->diffForHumans() }}</div>
            </div>
            <span class="rounded-full px-3 py-1 text-sm {{ $a->badge_class }}">{{ ucfirst($a->status) }}</span>
        </a>
    @empty
        <p class="p-8 text-center text-slate-500">No applications yet. Publish a job to start receiving them.</p>
    @endforelse
</div>
@endsection
