<div class="flex gap-2 mb-6 text-sm">
    @foreach (['admin.dashboard' => 'Overview', 'admin.users.index' => 'Users', 'admin.jobs.index' => 'Jobs', 'admin.categories.index' => 'Categories'] as $r => $l)
        <a href="{{ route($r) }}" class="px-3 py-1.5 rounded-full {{ request()->routeIs($r) ? 'bg-ink text-white' : 'bg-white border border-slate-200 hover:border-teal' }}">{{ $l }}</a>
    @endforeach
</div>
