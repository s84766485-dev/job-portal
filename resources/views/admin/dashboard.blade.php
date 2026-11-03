@extends('layouts.app')
@section('title', 'Admin')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-4">Admin overview</h1>
@include('admin._nav')

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @foreach (['candidates' => 'Candidates', 'employers' => 'Employers', 'jobs' => 'Total jobs', 'open_jobs' => 'Open jobs', 'applications' => 'Applications'] as $k => $l)
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <div class="font-display text-3xl font-bold text-ink">{{ $stats[$k] }}</div>
            <div class="text-sm text-slate-500">{{ $l }}</div>
        </div>
    @endforeach
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div>
        <h2 class="font-display text-xl font-bold text-ink mb-3">Newest users</h2>
        <div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
            @foreach ($latestUsers as $u)
                <div class="p-4 flex justify-between gap-3"><div><div class="font-medium">{{ $u->name }}</div><div class="text-sm text-slate-500">{{ $u->email }}</div></div>
                <span class="text-sm text-slate-500">{{ ucfirst($u->role) }}</span></div>
            @endforeach
        </div>
    </div>
    <div>
        <h2 class="font-display text-xl font-bold text-ink mb-3">Newest jobs</h2>
        <div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
            @foreach ($latestJobs as $j)
                <div class="p-4 flex justify-between gap-3"><div><div class="font-medium">{{ $j->title }}</div><div class="text-sm text-slate-500">{{ $j->company->name }}</div></div>
                <span class="text-sm text-slate-500">{{ ucfirst($j->status) }}</span></div>
            @endforeach
        </div>
    </div>
</div>
@endsection
