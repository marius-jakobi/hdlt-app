<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BillingAddress;
use Faker\Generator as Faker;

$factory->define(BillingAddress::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'street' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city
    ];
});
