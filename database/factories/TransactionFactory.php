<?php

use App\User;
use App\Seller;
use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    $vendedor = Seller::has('products')->get()->random();
    $comprador = User::all()->except($vendedor->id)->random();
    return [
        'quantity' => $faker->numberBetween(1, 3),
        'buyer_id' => $comprador->id,
        'product_id' => $vendedor->products->random()->id,
    ];
});
