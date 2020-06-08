<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ShippingAddress;
use Faker\Generator as Faker;

$factory->define(ShippingAddress::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'street' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city
    ];
});
