<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'phoneNumber' => $faker->phoneNumber ,
        'address' => $faker->country ,
        'city' => 5 ,
        'country' => 7 ,
        'email' => $faker->unique()->safeEmail
    ];
});
