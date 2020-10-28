<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin role
        $role = Role::create(['name' => Role::administratorRoleName(), 'description' => 'Administratoren']);
        // Attach admin role to admin user
        User::where('email', User::administratorEmail())->firstOrFail()->roles()->attach($role);
    }
}
