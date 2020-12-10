<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Skill;
use Faker\Generator as Faker;

$factory->define(Skill::class, function (Faker $faker) {
    return [
        'name' => $faker->unique($maxRetries = 50000)->randomElement([
            'Adobe XD',
            'PHP',
            'JAVA',
            'ANDROID',
            'Design',
            'Illustrator',
            'Administrasi',
            'Kemampuan Analitis',
            'Ketegasan',
            'Manajemen Anggaran',
            'Manajemen Bisnis',
            'Kolaborasi',
            'Komunikasi',
            'Manajemen Konflik',
            'Resolusi Konflik',
        ]),
    ];
});
