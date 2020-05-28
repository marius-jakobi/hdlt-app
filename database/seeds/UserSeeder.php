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
          'name_first' => 'Marius',
          'name_last' => 'Jakobi',
          'email' => 'm.jakobi@herbst-drucklufttechnik.de',
          'password' => Hash::make('start'),
          'email_verified_at' => now(),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
    }
}
