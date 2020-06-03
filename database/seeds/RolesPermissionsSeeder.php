<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator', 'description' => 'Administratoren']);

        $permission = Permission::create(['name' => 'create-users', 'description' => 'Die Rolle kann neue Benutzer erstellen']);

        User::findOrFail(1)->roles()->attach($role);
        $role->permissions()->attach($permission);
    }
}
