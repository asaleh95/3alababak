<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Onhand;
use Faker\Generator as Faker;

$factory->define(Onhand::class, function (Faker $faker) {
    return [
        //
        'primary_quantity' => randomDigit ,
        'pcs_quantity' => randomDigit,
    ];
});
