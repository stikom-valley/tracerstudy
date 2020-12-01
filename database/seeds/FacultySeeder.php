<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $batch = [
            [
                'name' => 'Fakultas Teknologi Informasi',
                'slug' => Str::slug('Fakultas Teknologi Informasi'),
            ], [
                'name' => 'Fakultas Ekonomi Bisnis',
                'slug' => Str::slug('Fakultas Ekonomi Bisnis'),
            ]
        ];

        DB::table('faculties')->insert($batch);
    }
}
