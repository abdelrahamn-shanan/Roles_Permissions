<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'add article',
            'view article',
            'edit article',
            'delete article',

            'add user',
            'view user',
            'edit user',
            'delete user',

            'add role',
            'view role',
            'edit role',
            'delete role',
            
            'add permission',
            'view permission',
            'edit permission',
            'delete permission',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());
        $staffRole->syncPermissions(['view article']);
    }
}
