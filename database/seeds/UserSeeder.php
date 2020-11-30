<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::unguard();
    //    User::truncate();
       factory(User::class)->create();
       User::reguard();
    }
}
