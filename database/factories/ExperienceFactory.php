<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Experience;
use Faker\Generator as Faker;

$factory->define(Experience::class, function (Faker $faker) {
    return [
        'company_name' => $faker->company,
        'job_title' => $faker->jobTitle,
        'is_present' => 0,
        'description' => $faker->text($maxNbChars = 200),
        'location' => $faker->streetAddress,
    ];
});
