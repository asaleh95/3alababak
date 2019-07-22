<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        //
        'name' => 'a'.$faker->name,
        // 'phoneNumber' => $faker->phoneNumber ,
        // 'address' => $faker->country ,
        // 'city' => 5 ,
        'email' => $faker->unique()->safeEmail
    ];
});
