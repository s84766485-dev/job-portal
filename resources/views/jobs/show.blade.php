@extends('layouts.app')
@section('title', $job->title)
@section('content')
<div class="grid lg:grid-cols-[1fr_20rem] gap-8">
    <article class="bg-white border border-slate-200 rounded-xl p-6 md:p-8">
        @unless ($job->isOpen())
            <div class="mb-4 rounded bg-amber/20 text-amber-900 px-3 py-2 text-sm">This job is {{ $job->status === 'published' ? 'past its deadline' : $job->status }} and is hidden from the public.</div>
        @endunless
        <h1 class="font-display text-3xl font-bold text-ink">{{ $job->title }}</h1>
        <p class="text-lg text-slate-600 mt-1">{{ $job->company->name }} — {{ $job->location }}</p>

        <div class="flex flex-wrap gap-2 mt-4 text-sm">
            <span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->type }}</span>
            <span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->level }} level</span>
            @if ($job->category)<span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->category->name }}</span>@endif
            @if ($job->salary_range)<span class="bg-teal/10 text-teal-dark rounded px-2 py-0.5">{{ $job->salary_range }}</span>@endif
        </div>

        <h2 class="font-display text-xl font-bold text-ink mt-8 mb-2">About the role</h2>
        <div class="whitespace-pre-line leading-relaxed max-w-prose">{{ $job->description }}</div>

        @if ($job->requirements)
            <h2 class="font-display text-xl font-bold text-ink mt-8 mb-2">What you bring</h2>
            <div class="whitespace-pre-line leading-relaxed max-w-prose">{{ $job->requirements }}</div>
        @endif
    </article>

    <aside class="space-y-6">
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            @if ($job->deadline)<p class="text-sm text-slate-500 mb-3">Apply by {{ $job->deadline->format('j M Y') }}</p>@endif

            @guest
                <a href="{{ route('login') }}" class="btn btn-primary w-full">Sign in to apply</a>
                <p class="text-sm text-slate-500 mt-3">New here? <a class="text-teal" href="{{ route('register') }}">Create a candidate account</a>.</p>
            @elseif (auth()->user()->isCandidate())
                @if ($application)
                    <p class="font-medium text-ink">You applied {{ $application->created_at->diffForHumans() }}.</p>
                    <span class="inline-block mt-2 rounded-full px-3 py-1 text-sm {{ $application->badge_class }}">{{ ucfirst($application->status) }}</span>
                @elseif ($job->isOpen())
                    <form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-sm font-medium" for="resume">Resume (PDF or Word, max 4 MB)</label>
                            <input id="resume" type="file" name="resume" accept=".pdf,.doc,.docx" required class="field mt-1 !p-2">
                            @error('resume')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium" for="cover_letter">Cover letter (optional)</label>
                            <textarea id="cover_letter" name="cover_letter" rows="5" class="field mt-1">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button class="btn btn-primary w-full">Send application</button>
                    </form>
                @endif
            @else
                <p class="text-sm text-slate-500">Only candidate accounts can apply for jobs.</p>
            @endguest
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="font-display font-bold text-ink">{{ $job->company->name }}</h2>
            @if ($job->company->location)<p class="text-sm text-slate-500">{{ $job->company->location }}</p>@endif
            @if ($job->company->description)<p class="text-sm mt-3">{{ Str::limit($job->company->description, 220) }}</p>@endif
            @if ($job->company->website)<a href="{{ $job->company->website }}" rel="noopener nofollow" target="_blank" class="text-sm text-teal mt-3 inline-block">Visit website</a>@endif
        </div>

        @if ($related->isNotEmpty())
            <div>
                <h2 class="font-display font-bold text-ink mb-3">Similar roles</h2>
                <div class="space-y-2">
                    @foreach ($related as $r)
                        <a href="{{ route('jobs.show', $r) }}" class="block bg-white border border-slate-200 rounded-lg px-4 py-3 hover:border-teal">
                            <div class="font-medium text-ink">{{ $r->title }}</div>
                            <div class="text-sm text-slate-500">{{ $r->company->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </aside>
</div>
@endsection
