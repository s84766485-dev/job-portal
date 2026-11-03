@php $err = fn ($f) => $errors->first($f); @endphp
<div class="bg-white border border-slate-200 rounded-xl p-6 space-y-4">
    <div>
        <label class="block text-sm font-medium mb-1" for="title">Job title</label>
        <input id="title" name="title" value="{{ old('title', $job->title) }}" required class="field">
        @if ($err('title'))<p class="text-sm text-rose-600 mt-1">{{ $err('title') }}</p>@endif
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1" for="category_id">Field</label>
            <select id="category_id" name="category_id" class="field">
                <option value="">Select a field</option>
                @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $job->category_id) == $c->id)>{{ $c->name }}</option>@endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="location">Location</label>
            <input id="location" name="location" value="{{ old('location', $job->location) }}" required class="field">
            @if ($err('location'))<p class="text-sm text-rose-600 mt-1">{{ $err('location') }}</p>@endif
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="type">Job type</label>
            <select id="type" name="type" class="field">
                @foreach (\App\Models\JobListing::TYPES as $t)<option @selected(old('type', $job->type) === $t)>{{ $t }}</option>@endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="level">Experience level</label>
            <select id="level" name="level" class="field">
                @foreach (\App\Models\JobListing::LEVELS as $l)<option @selected(old('level', $job->level) === $l)>{{ $l }}</option>@endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="salary_min">Minimum salary (per year)</label>
            <input id="salary_min" name="salary_min" type="number" min="0" value="{{ old('salary_min', $job->salary_min) }}" class="field">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="salary_max">Maximum salary (per year)</label>
            <input id="salary_max" name="salary_max" type="number" min="0" value="{{ old('salary_max', $job->salary_max) }}" class="field">
            @if ($err('salary_max'))<p class="text-sm text-rose-600 mt-1">Maximum salary must be at least the minimum.</p>@endif
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="deadline">Application deadline</label>
            <input id="deadline" name="deadline" type="date" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}" class="field">
            @if ($err('deadline'))<p class="text-sm text-rose-600 mt-1">{{ $err('deadline') }}</p>@endif
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" for="status">Status</label>
            <select id="status" name="status" class="field">
                @foreach (['draft' => 'Draft (hidden)', 'published' => 'Published', 'closed' => 'Closed'] as $v => $l)
                    <option value="{{ $v }}" @selected(old('status', $job->status ?: 'published') === $v)>{{ $l }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1" for="description">Description</label>
        <textarea id="description" name="description" rows="8" required class="field">{{ old('description', $job->description) }}</textarea>
        @if ($err('description'))<p class="text-sm text-rose-600 mt-1">{{ $err('description') }}</p>@endif
    </div>
    <div>
        <label class="block text-sm font-medium mb-1" for="requirements">Requirements</label>
        <textarea id="requirements" name="requirements" rows="5" class="field">{{ old('requirements', $job->requirements) }}</textarea>
    </div>

    <div class="flex gap-3">
        <button class="btn btn-primary">Save job</button>
        <a href="{{ route('employer.jobs.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</div>
