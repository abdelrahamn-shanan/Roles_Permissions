<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\CreatedUserRequest;
use App\Services\UserService;

class UserController extends Controller implements HasMiddleware
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $users = $this->userService->getAllUsers(10);

        return view('users.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->userService->getAllRoles();
       
        return view('users.create', compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatedUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());

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
        $user = $this->userService->findUser($user);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $roles = $this->userService->getAllRoles();
        $hasRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user','roles', 'hasRoles'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    { 
        try {
            $user = $this->userService->updateUser($id , $request->validated());
            if (!$user) {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }

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
            $deleted = $this->userService->deleteUser($id);
            if (!$deleted) {
                return redirect()->route('users.index')->with('error', 'User not found.');
            }
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) { 
            return redirect()->route('users.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
