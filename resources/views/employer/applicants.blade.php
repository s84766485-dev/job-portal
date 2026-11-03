@extends('layouts.app')
@section('title', 'Applicants')
@section('content')
<a href="{{ route('employer.jobs.index') }}" class="text-sm text-teal">Back to my jobs</a>
<h1 class="font-display text-3xl font-bold text-ink mt-1 mb-1">Applicants</h1>
<p class="text-slate-500 mb-6">{{ $job->title }} — {{ $applications->total() }} {{ Str::plural('application', $applications->total()) }}</p>

<form method="GET" class="mb-4 flex gap-2">
    <select name="status" class="field !w-auto" onchange="this.form.submit()" aria-label="Filter by status">
        <option value="">All statuses</option>
        @foreach (\App\Models\Application::STATUSES as $s)<option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>@endforeach
    </select>
</form>

<div class="space-y-4">
    @forelse ($applications as $a)
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <div class="flex flex-wrap items-start gap-4">
                <div class="flex-1 min-w-0">
                    <div class="font-display font-bold text-ink text-lg">{{ $a->candidate->name }}</div>
                    <a class="text-sm text-teal" href="mailto:{{ $a->candidate->email }}">{{ $a->candidate->email }}</a>
                    <div class="text-sm text-slate-500">Applied {{ $a->created_at->format('j M Y, H:i') }}</div>
                </div>
                <span class="rounded-full px-3 py-1 text-sm {{ $a->badge_class }}">{{ ucfirst($a->status) }}</span>
            </div>

            @if ($a->cover_letter)
                <details class="mt-3">
                    <summary class="cursor-pointer text-sm font-medium text-slate-600">Cover letter</summary>
                    <p class="mt-2 whitespace-pre-line text-slate-700 max-w-prose">{{ $a->cover_letter }}</p>
                </details>
            @endif

            <div class="mt-4 flex flex-wrap items-center gap-3">
                <a href="{{ route('employer.applications.resume', $a) }}" class="btn btn-ghost !py-1.5 text-sm">Download resume</a>
                <form method="POST" action="{{ route('employer.applications.update', $a) }}" class="flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="field !w-auto !py-1.5" aria-label="Application status">
                        @foreach (\App\Models\Application::STATUSES as $s)<option value="{{ $s }}" @selected($a->status === $s)>{{ ucfirst($s) }}</option>@endforeach
                    </select>
                    <button class="btn btn-primary !py-1.5 text-sm">Update status</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white border border-dashed border-slate-300 rounded-xl p-10 text-center text-slate-500">No applications match this view.</div>
    @endforelse
</div>
<div class="mt-6">{{ $applications->links() }}</div>
@endsection
