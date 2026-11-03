<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn ($q, $r) => $q->where('role', $r))
            ->when($request->q, fn ($q, $v) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%")))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggle(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Admin accounts cannot be deactivated here.');
        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->name.($user->is_active ? ' reactivated.' : ' deactivated.'));
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Admin accounts cannot be deleted here.');
        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
