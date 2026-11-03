@extends('layouts.app')
@section('title', 'Company profile')
@section('content')
<div class="max-w-2xl">
    <h1 class="font-display text-3xl font-bold text-ink mb-6">Company profile</h1>
    <form method="POST" action="{{ route('employer.company.update') }}" class="bg-white border border-slate-200 rounded-xl p-6 space-y-4">
        @csrf @method('PUT')
        @foreach ([['name','Company name','text',true],['website','Website (https://…)','url',false],['location','Headquarters','text',false]] as [$n,$l,$t,$req])
            <div>
                <label class="block text-sm font-medium mb-1" for="{{ $n }}">{{ $l }}</label>
                <input id="{{ $n }}" name="{{ $n }}" type="{{ $t }}" value="{{ old($n, $company->$n) }}" @required($req) class="field">
                @error($n)<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
        @endforeach
        <div>
            <label class="block text-sm font-medium mb-1" for="description">About the company</label>
            <textarea id="description" name="description" rows="6" class="field">{{ old('description', $company->description) }}</textarea>
            @error('description')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="btn btn-primary">Save company</button>
    </form>
</div>
@endsection
