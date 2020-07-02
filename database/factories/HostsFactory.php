<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Host;
use Faker\Generator as Faker;

$factory->define(Host::class, function (Faker $faker) {
    return [
      "email"  => $faker -> email(),
      "password" => $faker -> password(),
      "firstname" => $faker -> firstName(),
      "lastname" => $faker -> lastName(),
      "date_of_birth" => $faker -> date(),
      "credit_card" => $faker -> creditCardNumber()
    ];
});
