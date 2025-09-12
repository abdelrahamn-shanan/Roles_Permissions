<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getAllRoles($perPage = 10)
    {
        return Role::orderBy('name', 'DESC')->paginate($perPage);
    }

    public function getAllPermissions()
    {
        return Permission::orderBy('name','DESC')->get();
    }

    public function createRole(array $data)
    {
        $role = Role::create(['name' => $data['name']]);

        if (!empty($data['permissions'])) {
            $permissions = Permission::whereIn('id', $data['permissions'])->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function findRole($id)
    {
        return Role::find($id);
    }

    public function updateRole($id, array $data)
    {
        $role = $this->findRole($id);
        if(!$role) return null;

        $role->update(['name' => $data['name']]);
        
        if (!empty($data['permissions'])) {
            $permissions = Permission::whereIn('id', $data['permissions'])->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]); 
        }

        return $role;
    }

    public function deleteRole($id)
    {
        $role = $this->findRole($id);
        if(!$role) return false;

        $role->delete();
        return true;
    }
}
