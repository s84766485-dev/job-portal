@extends('layouts.app')
@section('title', 'Manage jobs')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-4">Jobs</h1>
@include('admin._nav')

<form method="GET" class="flex gap-2 mb-4">
    <input name="q" value="{{ request('q') }}" placeholder="Search job title" class="field !w-64">
    <select name="status" class="field !w-auto" onchange="this.form.submit()">
        <option value="">All statuses</option>
        @foreach (['draft', 'published', 'closed'] as $s)<option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>@endforeach
    </select>
    <button class="btn btn-ghost">Search</button>
</form>

<div class="bg-white border border-slate-200 rounded-xl overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-sm text-slate-500"><tr><th class="p-4">Job</th><th class="p-4">Status</th><th class="p-4">Applicants</th><th class="p-4"></th></tr></thead>
        <tbody class="divide-y divide-slate-100">
        @foreach ($jobs as $j)
            <tr>
                <td class="p-4"><a href="{{ route('jobs.show', $j) }}" class="font-medium text-ink hover:text-teal">{{ $j->title }}</a>
                    <div class="text-sm text-slate-500">{{ $j->company->name }}</div></td>
                <td class="p-4">
                    <form method="POST" action="{{ route('admin.jobs.status', $j) }}">@csrf @method('PATCH')
                        <select name="status" class="field !w-auto !py-1" onchange="this.form.submit()" aria-label="Status">
                            @foreach (['draft', 'published', 'closed'] as $s)<option value="{{ $s }}" @selected($j->status === $s)>{{ ucfirst($s) }}</option>@endforeach
                        </select>
                    </form>
                </td>
                <td class="p-4">{{ $j->applications_count }}</td>
                <td class="p-4 text-right whitespace-nowrap">
                    <form class="inline" method="POST" action="{{ route('admin.jobs.feature', $j) }}">@csrf @method('PATCH')
                        <button class="btn btn-ghost !py-1 text-sm">{{ $j->is_featured ? 'Unfeature' : 'Feature' }}</button></form>
                    <form class="inline" method="POST" action="{{ route('admin.jobs.destroy', $j) }}" onsubmit="return confirm('Delete this job?')">@csrf @method('DELETE')
                        <button class="btn btn-danger !py-1 text-sm">Delete</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $jobs->links() }}</div>
@endsection
