<?php

namespace Database\Seeders;
use DB;
use Faker\Factory;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $states = [];
        do {
            $states[] = $faker->state;
            $states = array_unique($states);
        }while(count($states) != 30);

        foreach($states as $state){
        DB::table('countries')->insert([
            'country_name' => $state,
            'amount_of_mines' => rand(1, 50),
        ]);
        }

        $names = [];
        do {
            $names[] = $faker->firstName;
            $names = array_unique($names);
        }while(count($names) != 30);

        static $n = 0;
        foreach($names as $name){
            DB::table('mines')->insert([
                'latitude' => $n,
                'longitude' => $n,
                'mine_name' => $name,
                'country_id' => rand(1, count($states)),
                'exploitation' => rand(100, 1000),
            ]);
          $n += 1;
            }
    }
}
