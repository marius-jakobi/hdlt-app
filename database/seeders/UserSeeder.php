<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'administrator@' . env('APP_HOST'); // administrator@localhost
        print("---------------------\n");
        print_r("Admin email: $email\n");
        print("---------------------\n");

        DB::table('users')->insert([
          'name_first' => 'Super',
          'name_last' => 'Administrator',
          'email' => $email,
          'password' => Hash::make(env('DB_PASSWORD')),
          'email_verified_at' => now(),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
    }
}
