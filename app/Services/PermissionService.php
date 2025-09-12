<?php
namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function getAllPaginated($perPage = 10)
    {
        return Permission::paginate($perPage);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function find($id)
    {
        return Permission::find($id);
    }

    public function update($id, array $data)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return null;
        }
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return null;
        }
        $permission->delete();
        return $permission;
    }
}
