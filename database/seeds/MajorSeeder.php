<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
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
                'name' => 'S1 Sistem Informasi',
                'slug' => Str::slug('S1 Sistem Informasi'),
                'faculty_id' => 1
            ], [
                'name' => 'S1 Teknik Komputer',
                'slug' => Str::slug('S1 Teknik Komputer'),
                'faculty_id' => 1
            ], [
                'name' => 'S1 Desain Komunikasi Visual',
                'slug' => Str::slug('S1 Desain Komunikasi Visual'),
                'faculty_id' => 1
            ], [
                'name' => 'S1 Desain Produk',
                'slug' => Str::slug('S1 Desain Produk'),
                'faculty_id' => 1
            ], [
                'name' => 'DIV Produksi Film Dan Televisi',
                'slug' => Str::slug('DIV Produksi Film Dan Televisi'),
                'faculty_id' => 1
            ], [
                'name' => 'DIII Sistem Informasi',
                'slug' => Str::slug('DIII Sistem Informasi'),
                'faculty_id' => 1
            ], [
                'name' => 'S1 Manajemen',
                'slug' => Str::slug('S1 Manajemen'),
                'faculty_id' => 2
            ], [
                'name' => 'S1 Akuntansi',
                'slug' => Str::slug('S1 Akuntansi'),
                'faculty_id' => 2
            ], [
                'name' => 'DIII Administrasi Perkantoran',
                'slug' => Str::slug('DIII Administrasi Perkantoran'),
                'faculty_id' => 2
            ],
        ];

        DB::table('majors')->insert($batch);
    }
}
