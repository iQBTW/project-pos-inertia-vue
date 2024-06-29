<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::when($request->q, function ($query, $q) {
            $query->where("name", "like", "%" . $q . "%");
        })->paginate(10);

        return Inertia::render('Admin/Permission/Index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name|max:255',
        ]);

        $permission = Permission::create($validated);

        if ($permission) {
            return redirect()->route('permission.index')->with('success', 'Permission created successfully');
        }
        else {
            return redirect()->route('permission.index')->with('error', 'There has been an error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update($validated);

        if ($permission) {
            return redirect()->route('permission.index')->with('success', 'Permission updated successfully');
        }
        else {
            return redirect()->route('permission.index')->with('error', 'Failed to update permission');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        if ($permission) {
            return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
        }
        else {
            return redirect()->route('permission.index')->with('error', 'Failed to delete permission');
        }
    }
}
