<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Education;
use Faker\Generator as Faker;

$factory->define(Education::class, function (Faker $faker) {
    $faculty = $faker->randomElement(['1', '2']);

    if ($faculty == 1) {
        $major = $faker->numberBetween($min = 1, $max = 6);
    } else if ($faculty == 2) {
        $major = $faker->numberBetween($min = 7, $max = 9);
    }

    return [
        'score' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 2, $max = 4),
        'faculty_id' => $faculty,
        'major_id' => $major,
    ];
});
