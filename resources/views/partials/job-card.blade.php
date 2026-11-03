<a href="{{ route('jobs.show', $job) }}" class="block bg-white border border-slate-200 rounded-xl p-5 hover:border-teal transition-colors">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h3 class="font-display text-lg font-bold text-ink">{{ $job->title }}</h3>
            <p class="text-slate-600">{{ $job->company->name }} — {{ $job->location }}</p>
        </div>
        @if ($job->is_featured)
            <span class="shrink-0 text-xs font-semibold bg-amber/20 text-amber-900 rounded-full px-2.5 py-1">Featured</span>
        @endif
    </div>
    <div class="flex flex-wrap gap-2 mt-3 text-sm">
        <span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->type }}</span>
        <span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->level }} level</span>
        @if ($job->category)<span class="bg-slate-100 rounded px-2 py-0.5">{{ $job->category->name }}</span>@endif
        @if ($job->salary_range)<span class="bg-teal/10 text-teal-dark rounded px-2 py-0.5">{{ $job->salary_range }}</span>@endif
        <span class="text-slate-400 ml-auto">{{ $job->created_at->diffForHumans() }}</span>
    </div>
</a>
