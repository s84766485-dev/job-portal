@extends('layouts.app')
@section('title', 'Create account')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl border border-slate-200 p-8">
    <h1 class="font-display text-2xl font-bold text-ink mb-6">Create your account</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <fieldset>
            <legend class="text-sm font-medium mb-2">I want to</legend>
            <div class="grid grid-cols-2 gap-3">
                @foreach (['candidate' => 'Find a job', 'employer' => 'Hire people'] as $val => $label)
                    <label class="border rounded-lg px-4 py-3 cursor-pointer has-[:checked]:border-teal has-[:checked]:bg-teal/5">
                        <input type="radio" name="role" value="{{ $val }}" class="mr-2" onchange="toggleCompany()" @checked(old('role', 'candidate') === $val)> {{ $label }}
                    </label>
                @endforeach
            </div>
            @error('role')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </fieldset>

        @foreach ([['name','Full name','text'],['email','Email','email'],['password','Password (8+ characters)','password'],['password_confirmation','Confirm password','password']] as [$n,$l,$t])
            <div>
                <label class="block text-sm font-medium mb-1" for="{{ $n }}">{{ $l }}</label>
                <input id="{{ $n }}" name="{{ $n }}" type="{{ $t }}" value="{{ $t === 'password' ? '' : old($n) }}" required class="field">
                @error($n)<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
        @endforeach

        <div id="company-field" class="{{ old('role') === 'employer' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium mb-1" for="company_name">Company name</label>
            <input id="company_name" name="company_name" value="{{ old('company_name') }}" class="field">
            @error('company_name')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <button class="btn btn-primary w-full">Create account</button>
    </form>
    <p class="text-sm text-slate-500 mt-6">Already registered? <a class="text-teal font-medium" href="{{ route('login') }}">Sign in</a></p>
</div>
<script>
    function toggleCompany() {
        const employer = document.querySelector('input[name=role]:checked').value === 'employer';
        document.getElementById('company-field').classList.toggle('hidden', ! employer);
    }
</script>
@endsection
