<?php

use App\User;
use App\Skill;
use App\Education;
use Carbon\Carbon;
use App\Experience;
use Illuminate\Database\Seeder;

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

      factory(User::class, 1)->create([
         'role_id' => 1
      ]);

      factory(User::class, 1)->create([
         'role_id' => 2
      ]);

      $user2015 = factory(User::class, 32)->create([
         'role_id' => 3
      ]);

      $user2015->each(function ($user1) {

         $date = Carbon::create(2015, 1, 1, 0, 0, 0);

         factory(Education::class)->create([
            'user_id' => $user1,
            'entry_year' => $date->format('Y'),
            'graduation_year' => $date->addYears(4)->format('Y'),
         ]);

         factory(Experience::class, 2)->create([
            'user_id' => $user1,
            'start_date' => $date->addYear()->format('Y-m-d'),
            'end_date' => $date->addYears(3)->format('Y-m-d'),
         ]);

         factory(Skill::class, 4)->create([
            'user_id' => $user1
         ]);
      });

      $user2016 = factory(User::class, 20)->create([
         'role_id' => 3
      ]);

      $user2016->each(function ($user1) {

         $date = Carbon::create(2016, 1, 1, 0, 0, 0);

         factory(Education::class)->create([
            'user_id' => $user1,
            'entry_year' => $date->format('Y'),
            'graduation_year' => $date->addYears(4)->format('Y'),
         ]);

         factory(Experience::class, 2)->create([
            'user_id' => $user1,
            'start_date' => $date->addYear()->format('Y-m-d'),
            'end_date' => $date->addYears(3)->format('Y-m-d'),
         ]);

         factory(Skill::class, 4)->create([
            'user_id' => $user1
         ]);
      });

      $user2017 = factory(User::class, 13)->create([
         'role_id' => 3
      ]);

      $user2017->each(function ($user1) {

         $date = Carbon::create(2017, 1, 1, 0, 0, 0);

         factory(Education::class)->create([
            'user_id' => $user1,
            'entry_year' => $date->format('Y'),
            'graduation_year' => $date->addYears(4)->format('Y'),
         ]);

         factory(Experience::class, 2)->create([
            'user_id' => $user1,
            'start_date' => $date->addYear()->format('Y-m-d'),
            'end_date' => $date->addYears(3)->format('Y-m-d'),
         ]);

         factory(Skill::class, 4)->create([
            'user_id' => $user1
         ]);
      });

      $user2018 = factory(User::class, 6)->create([
         'role_id' => 3
      ]);

      $user2018->each(function ($user1) {

         $date = Carbon::create(2018, 1, 1, 0, 0, 0);

         factory(Education::class)->create([
            'user_id' => $user1,
            'entry_year' => $date->format('Y'),
            'graduation_year' => $date->addYears(4)->format('Y'),
         ]);

         factory(Experience::class, 2)->create([
            'user_id' => $user1,
            'start_date' => $date->addYear()->format('Y-m-d'),
            'end_date' => $date->addYears(3)->format('Y-m-d'),
         ]);

         factory(Skill::class, 4)->create([
            'user_id' => $user1
         ]);
      });

      User::reguard();
   }
}
