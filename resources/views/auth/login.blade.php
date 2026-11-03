@extends('layouts.app')
@section('title', 'Sign in')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl border border-slate-200 p-8">
    <h1 class="font-display text-2xl font-bold text-ink mb-6">Sign in</h1>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="field">
            @error('email')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="password">Password</label>
            <input id="password" name="password" type="password" required class="field">
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Keep me signed in</label>
        <button class="btn btn-primary w-full">Sign in</button>
    </form>
    <p class="text-sm text-slate-500 mt-6">No account? <a class="text-teal font-medium" href="{{ route('register') }}">Create one</a></p>
</div>
@endsection
