<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = config('permission.permissions');


        foreach ($permissions as $module => $permissions) {

            foreach ($permissions as $permission)
            {
                Permission::firstOrCreate(['module' => $module, 'name' => $permission]);
            }

        }



        foreach (RoleEnum::cases() as $roleEnum) {
            Role::firstOrCreate(['name' => $roleEnum->value]);
        }

        $role = Role::findByName(RoleEnum::ADMINISTRATOR->name);
        $role->givePermissionTo([
            'user:create',
            'user:edit',
            'user:index',
            'user:delete',
        ]);
    }
}
