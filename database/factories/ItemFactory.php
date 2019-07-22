<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Item;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Item::class, function (Faker $faker) {
    return [
        //
        'code' => md5(microtime()),
        'name' => $faker->name,
        'description' => $faker->sentence,
        // 'vat' => range(0 , 50) ,
        // 'expiry_date' => (Carbon::now())->addWeeks(2),
        // 'status_lookup' => 1 , 
    ];
});
