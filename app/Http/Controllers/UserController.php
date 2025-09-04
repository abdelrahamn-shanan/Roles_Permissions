<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\CreatedUserRequest;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:add user', only: ['create','store']),
            new Middleware('permission:edit user', only: ['edit','update']),
            new Middleware('permission:delete user', only: ['destroy']),    
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatedUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->assignRole($roles);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) { 
            return redirect()->route('users.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        $user = User::find($user);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $roles = Role::all();
        $hasRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user','roles', 'hasRoles'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    { 
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->syncRoles($roles);

            return redirect()->route('users.index')->with('success', 'User roles updated successfully.');
        } catch (\Exception $e) { 
            return redirect()->route('users.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) { 
            return redirect()->route('users.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
