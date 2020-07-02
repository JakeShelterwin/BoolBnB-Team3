<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sponsor;
use Faker\Generator as Faker;

$factory->define(Sponsor::class, function (Faker $faker) {
    $randomIndex = array_rand(["x","y","z"],1);
    $name = ["bronze", "silver", "gold"];
    $duration = ["86400","259200","518400"];
    $price = ["2.99","5.99","9.99"];
    return [
    "name" => $name[$randomIndex],
    "duration" => $duration[$randomIndex],
    "price" => $price[$randomIndex],
    ];
});
