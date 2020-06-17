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

        foreach (['Innendienst', 'Außendienst', 'Techniker'] as $role) {
            $newRole = new Role([
                'name' => $role,
                'description' => $role
            ]);

            $roles[] = $newRole;

            $newRole->save();
        }

        $methods = ['create', 'view', 'update'];
        $entities = ['customer', 'shipping-address', 'component'];

        foreach ($methods as $method) {
            foreach ($entities as $entity) {
                $permission = new Permission([
                    'name' => "$method-$entity",
                    'description' => "Role can $method $entity"
                ]);

                $permission->save();

                if ($method === 'view') {
                    foreach($roles as $role) {
                        $role->permissions()->attach($permission);
                    }
                }
            }
        }
    }
}
