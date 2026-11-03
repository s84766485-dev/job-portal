@extends('layouts.app')
@section('title', 'Users')
@section('content')
<h1 class="font-display text-3xl font-bold text-ink mb-4">Users</h1>
@include('admin._nav')

<form method="GET" class="flex gap-2 mb-4">
    <input name="q" value="{{ request('q') }}" placeholder="Search name or email" class="field !w-64">
    <select name="role" class="field !w-auto" onchange="this.form.submit()">
        <option value="">All roles</option>
        @foreach (['candidate', 'employer', 'admin'] as $r)<option value="{{ $r }}" @selected(request('role') === $r)>{{ ucfirst($r) }}</option>@endforeach
    </select>
    <button class="btn btn-ghost">Search</button>
</form>

<div class="bg-white border border-slate-200 rounded-xl overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-sm text-slate-500"><tr><th class="p-4">Name</th><th class="p-4">Role</th><th class="p-4">Joined</th><th class="p-4">Status</th><th class="p-4"></th></tr></thead>
        <tbody class="divide-y divide-slate-100">
        @foreach ($users as $u)
            <tr>
                <td class="p-4"><div class="font-medium">{{ $u->name }}</div><div class="text-sm text-slate-500">{{ $u->email }}</div></td>
                <td class="p-4">{{ ucfirst($u->role) }}</td>
                <td class="p-4 text-slate-500">{{ $u->created_at->format('j M Y') }}</td>
                <td class="p-4"><span class="rounded-full px-2.5 py-0.5 text-sm {{ $u->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $u->is_active ? 'Active' : 'Deactivated' }}</span></td>
                <td class="p-4 text-right whitespace-nowrap">
                    @unless ($u->isAdmin())
                        <form class="inline" method="POST" action="{{ route('admin.users.toggle', $u) }}">@csrf @method('PATCH')
                            <button class="btn btn-ghost !py-1 text-sm">{{ $u->is_active ? 'Deactivate' : 'Reactivate' }}</button></form>
                        <form class="inline" method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user and everything they own?')">@csrf @method('DELETE')
                            <button class="btn btn-danger !py-1 text-sm">Delete</button></form>
                    @endunless
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection
