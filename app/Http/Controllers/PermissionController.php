<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\PermissionService;

class PermissionController extends Controller implements HasMiddleware
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:add permission', only: ['create','store']),
            new Middleware('permission:edit permission', only: ['edit','update']),
            new Middleware('permission:delete permission', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->permissionService->getAllPaginated(10);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        $this->permissionService->create($request->only('name'));
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }


    public function edit($id)
    {
        $permission = $this->permissionService->find($id);

        if(!$permission){
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
        }
        return view('permissions.edit', compact('permission'));
    }


    public function update(PermissionRequest $request , $id)
    {
        $permission = $this->permissionService->find($id);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        $permission = $this->permissionService->find($id);
        if(!$permission){
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
        }
        $this->permissionService->delete($id);
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
