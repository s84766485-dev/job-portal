@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-4">Categories</h1>
@include('admin._nav')

<div class="grid md:grid-cols-[1fr_20rem] gap-6 items-start">
    <div class="bg-white border border-slate-200 rounded-xl divide-y divide-slate-100">
        @forelse ($categories as $c)
            <div class="p-4 flex items-center gap-3">
                <div class="flex-1"><span class="font-medium">{{ $c->name }}</span> <span class="text-sm text-slate-500">· {{ $c->jobs_count }} {{ Str::plural('job', $c->jobs_count) }}</span></div>
                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Remove this category? Its jobs will become uncategorised.')">@csrf @method('DELETE')
                    <button class="btn btn-danger !py-1 text-sm">Remove</button></form>
            </div>
        @empty
            <p class="p-8 text-center text-slate-500">No categories yet. Add the first one.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white border border-slate-200 rounded-xl p-5 space-y-3">
        @csrf
        <label class="block text-sm font-medium" for="name">New category</label>
        <input id="name" name="name" value="{{ old('name') }}" required class="field">
        @error('name')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
        <button class="btn btn-primary w-full">Add category</button>
    </form>
</div>
@endsection
