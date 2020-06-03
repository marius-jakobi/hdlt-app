<?php

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
        DB::table('users')->insert([
          'name_first' => 'Super',
          'name_last' => 'Administrator',
          'email' => 'administrator@' . env('APP_HOST'),
          'password' => Hash::make(env('DB_PASSWORD')),
          'email_verified_at' => now(),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
    }
}
