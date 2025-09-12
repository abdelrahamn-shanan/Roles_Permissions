<?php
namespace App\Services;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserService
{

    public function getAllUsers($perPage = 10)
    {
        return User::orderBy('name', 'DESC')->paginate($perPage);
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleNamesByIds(array $roleIds)
    {
        return Role::whereIn('id', $roleIds)->pluck('name')->toArray();
    }

    public function createUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if (!empty($data['roles'])) {
            $roles = $this->getRoleNamesByIds($data['roles']);
            $user->assignRole($roles);
        }

        return $user;
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->findUser($id);
        if(!$user) return null;
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (!empty($data['roles'])) {
            $roles = $this->getRoleNamesByIds($data['roles']);
            $user->syncRoles($roles);
        }

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->findUser($id);
        if(!$user) return false;

        $user->delete();
        return true;
    }





}