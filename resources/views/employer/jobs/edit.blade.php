@extends('layouts.app')
@section('title', 'Edit job')
@section('content')
<div class="max-w-3xl">
    <h1 class="font-display text-3xl font-bold text-ink mb-6">Edit job</h1>
    <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
        @csrf @method('PUT')
        @include('employer.jobs.form')
    </form>
</div>
@endsection
