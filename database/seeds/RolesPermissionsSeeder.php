<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = Role::create(['name' => 'administrator', 'description' => 'Administratoren']);

        $createUsers = Permission::create(['name' => 'create-users', 'description' => 'Die Rolle kann neue Benutzer erstellen']);
    }
}
