<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RolesPermissionsSeeder::class,
            PermissionSeeder::class
            // CustomerSeeder::class,
            // BrandsSeeder::class,
        ]);
    }
}
