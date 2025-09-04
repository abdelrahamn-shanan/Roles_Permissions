<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:add role', only: ['create','store']),
            new Middleware('permission:edit role', only: ['edit','update']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name','DESC')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name','DESC')->get();
        return view('roles.create', compact('permissions'));
    }


    public function store(RoleRequest $request)
    { 
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::find($id);

        if(!$role){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }
    
        $permissions = Permission::orderBy('name','DESC')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, $id)
    { 
        $role = Role::find($id);
        if(!$role){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }
        $role->update(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($role)
    {
        $role = Role::find($role);
        if(!$role){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

}
