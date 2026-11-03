@extends('layouts.app')
@section('title', 'My applications')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-6">My applications</h1>

<div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
    @forelse ($applications as $a)
        <div class="p-5 flex flex-wrap items-center gap-4">
            <div class="min-w-0 flex-1">
                <a href="{{ route('jobs.show', $a->job) }}" class="font-display font-bold text-ink hover:text-teal">{{ $a->job->title }}</a>
                <p class="text-sm text-slate-500">{{ $a->job->company->name }} — applied {{ $a->created_at->format('j M Y') }}</p>
            </div>
            <span class="rounded-full px-3 py-1 text-sm {{ $a->badge_class }}">{{ ucfirst($a->status) }}</span>
            @if ($a->status === 'pending')
                <form method="POST" action="{{ route('candidate.applications.withdraw', $a) }}" onsubmit="return confirm('Withdraw this application?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger !py-1 text-sm">Withdraw</button>
                </form>
            @endif
        </div>
    @empty
        <div class="p-10 text-center text-slate-500">You haven't applied for anything yet. <a class="text-teal" href="{{ route('jobs.index') }}">Browse open jobs</a>.</div>
    @endforelse
</div>
<div class="mt-6">{{ $applications->links() }}</div>
@endsection
