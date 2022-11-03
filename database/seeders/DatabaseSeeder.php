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
    }
}
