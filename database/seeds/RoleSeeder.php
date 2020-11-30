<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
                'name' => 'Bagian Pengelolaan Alumni',
                'slug' => Str::slug('BPA'),
            ],[
                'name' => 'Wakil Rektor Bidang Alumni',
                'slug' => Str::slug('Warek Alumni'),
            ],[
                'name' => 'Alumni',
                'slug' => Str::slug('Alumni'),
            ],
        ];

        DB::table('roles')->insert($batch);
    }
}
