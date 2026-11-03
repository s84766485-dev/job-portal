@extends('layouts.app')
@section('title', 'Find your next role')
@section('content')

<section class="rounded-2xl bg-ink text-white px-6 py-12 md:px-12 md:py-16 mb-10">
    <h1 class="font-display text-4xl md:text-5xl font-bold tracking-tight max-w-2xl">Skip the noise. Find work worth applying for.</h1>
    <p class="text-slate-300 mt-4 max-w-xl text-lg">Search open roles from employers who are hiring right now, and apply with your resume in under a minute.</p>

    <form action="{{ route('jobs.index') }}" method="GET" class="mt-8 grid md:grid-cols-[1fr_14rem_auto] gap-3 max-w-3xl">
        <input name="q" placeholder="Job title, skill or company" class="field !text-slate-900" aria-label="Keyword">
        <input name="location" placeholder="Location" class="field !text-slate-900" aria-label="Location">
        <button class="btn btn-primary !px-6">Search jobs</button>
    </form>
</section>

@if ($categories->isNotEmpty())
<section class="mb-10">
    <h2 class="font-display text-2xl font-bold text-ink mb-4">Browse by field</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @foreach ($categories as $c)
            <a href="{{ route('jobs.index', ['category' => $c->id]) }}" class="bg-white border border-slate-200 rounded-lg px-4 py-3 hover:border-teal">
                <div class="font-medium text-ink">{{ $c->name }}</div>
                <div class="text-sm text-slate-500">{{ $c->jobs_count }} open {{ Str::plural('role', $c->jobs_count) }}</div>
            </a>
        @endforeach
    </div>
</section>
@endif

@if ($featured->isNotEmpty())
<section class="mb-10">
    <h2 class="font-display text-2xl font-bold text-ink mb-4">Featured roles</h2>
    <div class="grid md:grid-cols-2 gap-4">
        @foreach ($featured as $job) @include('partials.job-card', ['job' => $job]) @endforeach
    </div>
</section>
@endif

<section>
    <div class="flex items-end justify-between mb-4">
        <h2 class="font-display text-2xl font-bold text-ink">Latest jobs</h2>
        <a href="{{ route('jobs.index') }}" class="text-teal font-medium">See all jobs</a>
    </div>
    <div class="space-y-3">
        @forelse ($latest as $job)
            @include('partials.job-card', ['job' => $job])
        @empty
            <p class="text-slate-500">No open jobs yet. Employers can <a class="text-teal" href="{{ route('register') }}">create an account</a> to post the first one.</p>
        @endforelse
    </div>
</section>
@endsection
