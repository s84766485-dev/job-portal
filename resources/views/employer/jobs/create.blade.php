@extends('layouts.app')
@section('title', 'Post a job')
@section('content')
<div class="max-w-3xl">
    <h1 class="font-display text-3xl font-bold text-ink mb-6">Post a job</h1>
    <form method="POST" action="{{ route('employer.jobs.store') }}">
        @csrf
        @include('employer.jobs.form')
    </form>
</div>
@endsection
