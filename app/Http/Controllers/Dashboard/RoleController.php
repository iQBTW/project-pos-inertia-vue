<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::when($request->q, function ($query, $q) {
            $query->where('name', 'like', '%' . $q . '%');
        })->paginate(10);

        return Inertia::render('Admin/Role/Index', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create($validated);

        if ($role) {
            return redirect()->route('role.index')->with('success', 'Role created successfully');
        }
        else {
            return redirect()->route('role.index')->with('error', 'There has been an error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update($validated);

        if ($role) {
            return redirect()->route('role.index')->with('success', 'Role updated successfully');
        }
        else {
            return redirect()->route('role.index')->with('error', 'Failed to update role');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $data = $role->delete();

        if ($data) {
            return redirect()->route('role.index')->with('success', 'Role has been deleted succesfully');
        }
        else {
            return redirect()->route('role.index')->with('error', 'Failed to delete role');
        }
    }
}
