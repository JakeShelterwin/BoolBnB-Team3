<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LocationMessage;
use Faker\Generator as Faker;

$factory->define(LocationMessage::class, function (Faker $faker) {
    return [
      "email"  => $faker -> email(),
      "message" => $faker -> sentence()
    ];
});
