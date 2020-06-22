<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];
        $permissions = [];

        // Create roles
        foreach (['Innendienst', 'Außendienst', 'Techniker'] as $role) {
            $newRole = new Role([
                'name' => $role,
                'description' => $role
            ]);

            $roles[] = $newRole;

            $newRole->save();
        }

        // Create basic permissions
        $methods = ['create', 'view', 'update'];
        $entities = ['customer', 'shipping-address', 'component'];

        foreach ($methods as $method) {
            foreach ($entities as $entity) {
                $permission = new Permission([
                    'name' => "$method-$entity",
                    'description' => "Role can $method $entity"
                ]);

                $permissions[] = $permission;

                $permission->save();

                // Add view permissions to every role
                if ($method === 'view') {
                    foreach($roles as $role) {
                        $role->permissions()->attach($permission);
                    }
                }
            }
        }

        // Get admin
        $administrator = Role::where('name', Role::administratorRoleName())->first();
        // Add every permission to admin role
        foreach ($permissions as $permission) {
            $administrator->permissions()->attach($permission);
        }
    }
}
