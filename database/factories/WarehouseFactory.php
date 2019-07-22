<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Warehouse;
use Faker\Generator as Faker;

$factory->define(Warehouse::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'location' => $faker->address,
        'city' => 5 ,
    ];
});
