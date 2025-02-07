<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->q, function ($query, $q) {
            $query->where('name', 'like', '%' . $q . '%');
            $query->orWhere('email', 'like', '%' . $q . '%');
            $query->orWhere('address', 'like', '%' . $q . '%');
        })->latest()->paginate(10);

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'search' => $request->only('q')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/User/Create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'role' => 'required|in:user,admin'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'address' => $validated['address'],
        ]);

        $user->assignRole($validated['role']);

        if ($user) {
            return redirect()->route('user.index')->with('success', 'User created successfully');
        }
        else {
            return redirect()->route('user.index')->with('error', 'There has been an error');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'address' => 'required|string|max:255',
            'role' => 'required|in:user,admin'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        $user->syncRoles([$validated['role']]);

        if ($user) {
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
        else {
            return redirect()->route('user.index')->with('error', 'Failed to update user');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        if ($user) {
            return redirect(route('user.index'))->with('success', 'User has been deleted succesfully');
        }
        else {
            return redirect(route('user.index'))->with('error', 'Failed to delete user');
        }
    }
}
