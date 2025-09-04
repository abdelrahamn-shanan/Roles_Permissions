<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{

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
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {

        Permission::create($request->only('name'));

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }


    public function edit($id)
    {
        $permission = Permission::find($id);

        if(!$permission){
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
        }
        return view('permissions.edit', compact('permission'));
    }


    public function update(PermissionRequest $request , $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        $permission = Permission::find($id);

        if(!$permission){
            return redirect()->route('permissions.index')->with('error', 'Permission not found.');
        }
        
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
