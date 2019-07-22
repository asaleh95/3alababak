<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Locator;
use Faker\Generator as Faker;

$factory->define(Locator::class, function (Faker $faker) {
    return [
        //
        'code' => md5(microtime()),
        'description' => $faker->sentence,
    ];
});
