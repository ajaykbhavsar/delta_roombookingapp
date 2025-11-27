<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->assignableRoles();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,user',
        ]);

        if ($validated['role'] === 'super_admin' && !$this->currentUser()->isSuperAdmin()) {
            return redirect()->back()
                ->withErrors(['role' => 'Only Super Admin can assign this role.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Assign role using Spatie Permission
        $role = Role::where('name', $validated['role'])->first();
        if ($role) {
            $user->assignRole($role);
        }

        SystemLog::record('user_created', [
            'summary' => "Created user {$user->name}",
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        $recentLogs = SystemLog::where('performed_by', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.users.show', compact('user', 'recentLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = $this->assignableRoles();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,super_admin,user',
        ]);

        if ($validated['role'] === 'super_admin' && !$this->currentUser()->isSuperAdmin()) {
            return redirect()->back()
                ->withErrors(['role' => 'Only Super Admin can assign this role.'])
                ->withInput();
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Update role using Spatie Permission
        $user->roles()->detach();
        $role = Role::where('name', $validated['role'])->first();
        if ($role) {
            $user->assignRole($role);
        }

        SystemLog::record('user_updated', [
            'summary' => "Updated user {$user->name}",
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$this->currentUser()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Only Super Admin can delete users.');
        }

        // Prevent deleting the current logged-in user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $userId = $user->id;

        $user->delete();

        SystemLog::record('user_deleted', [
            'summary' => "Deleted user {$userName}",
            'user_id' => $userId,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    protected function assignableRoles()
    {
        return Role::when(!$this->currentUser()->isSuperAdmin(), function ($query) {
                $query->where('name', '!=', 'super_admin');
            })
            ->orderBy('name')
            ->get();
    }

    protected function currentUser(): User
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user;
    }
}
