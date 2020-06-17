<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'description' => $faker->company,
        'cust_id' => 'D' . rand(30000, 39999)
    ];
});
