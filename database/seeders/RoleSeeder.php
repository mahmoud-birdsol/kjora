<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Pktharindu\NovaPermissions\Permission;
use Pktharindu\NovaPermissions\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super admin',
        ]);

        $developer = Role::create([
            'name' => 'Developer',
            'slug' => 'developer',
        ]);

        foreach (config('nova-permissions.permissions') as $key => $permission) {
            Permission::create([
                'role_id' => $superAdmin->id,
                'permission_slug' => $key,
            ]);

            Permission::create([
                'role_id' => $developer->id,
                'permission_slug' => $key,
            ]);
        }
    }
}
