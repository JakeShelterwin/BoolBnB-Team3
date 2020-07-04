<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apartment;
use Faker\Generator as Faker;

$factory->define(Apartment::class, function (Faker $faker) {
    return [
      "title" => $faker -> word(),
      "lat" => $faker -> latitude(),
      "lon" => $faker -> longitude(),
      "description" => $faker -> sentence(),
      "rooms_n" => $faker -> numberBetween(1, 10),
      "beds_n" => $faker -> numberBetween(1, 4),
      "bathrooms_n" => $faker -> numberBetween(1, 3),
      "square_meters" => $faker -> numberBetween(30, 100),
      "address" => $faker -> address(),
      "image" => $faker -> word(),
      "is_active" => $faker -> boolean(true),
      "sponsor_expire_time" => $faker -> numberBetween(1, 100)
    ];
});
