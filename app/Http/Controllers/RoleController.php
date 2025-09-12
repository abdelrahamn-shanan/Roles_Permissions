<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:add role', only: ['create','store']),
            new Middleware('permission:edit role', only: ['edit','update']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAllPermissions();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->roleService->createRole($request->validated());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->roleService->findRole($id);
        if(!$role){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        $permissions = $this->roleService->getAllPermissions();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, $id)
    {
        $role = $this->roleService->updateRole($id, $request->validated());
        if(!$role){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->roleService->deleteRole($id);
        if(!$deleted){
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
