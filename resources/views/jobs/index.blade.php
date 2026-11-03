@extends('layouts.app')
@section('title', 'Browse jobs')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-6">Browse jobs</h1>

<div class="grid lg:grid-cols-[16rem_1fr] gap-8">
    <form method="GET" class="bg-white border border-slate-200 rounded-xl p-5 space-y-4 h-fit">
        <div><label class="text-sm font-medium" for="q">Keyword</label>
            <input id="q" name="q" value="{{ request('q') }}" class="field mt-1"></div>
        <div><label class="text-sm font-medium" for="location">Location</label>
            <input id="location" name="location" value="{{ request('location') }}" class="field mt-1"></div>
        <div><label class="text-sm font-medium" for="category">Field</label>
            <select id="category" name="category" class="field mt-1">
                <option value="">All fields</option>
                @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>@endforeach
            </select></div>
        <div><label class="text-sm font-medium" for="type">Job type</label>
            <select id="type" name="type" class="field mt-1">
                <option value="">Any type</option>
                @foreach (\App\Models\JobListing::TYPES as $t)<option @selected(request('type') === $t)>{{ $t }}</option>@endforeach
            </select></div>
        <div><label class="text-sm font-medium" for="level">Experience</label>
            <select id="level" name="level" class="field mt-1">
                <option value="">Any level</option>
                @foreach (\App\Models\JobListing::LEVELS as $l)<option @selected(request('level') === $l)>{{ $l }}</option>@endforeach
            </select></div>
        <button class="btn btn-primary w-full">Apply filters</button>
        <a href="{{ route('jobs.index') }}" class="block text-center text-sm text-slate-500">Clear filters</a>
    </form>

    <div>
        <p class="text-slate-500 mb-3">{{ $jobs->total() }} {{ Str::plural('job', $jobs->total()) }} found</p>
        <div class="space-y-3">
            @forelse ($jobs as $job)
                @include('partials.job-card', ['job' => $job])
            @empty
                <div class="bg-white border border-dashed border-slate-300 rounded-xl p-10 text-center text-slate-500">
                    Nothing matches those filters. Try a broader keyword or clear the filters.
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $jobs->links() }}</div>
    </div>
</div>
@endsection
