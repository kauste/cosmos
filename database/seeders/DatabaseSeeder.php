<?php

namespace Database\Seeders;
use DB;
use App\Models\Country;
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

        $namesMines = [];
        do {
            $namesMines[] = $faker->firstNameFemale;
            $namesMines = array_unique($namesMines);
        }while(count($namesMines) != 30);

        static $n = 0;
        foreach($namesMines as $name){
            DB::table('mines')->insert([
                'latitude' => $n,
                'longitude' => $n,
                'mine_name' => $name,
                'country_id' => rand(1, count($states)),
                'exploitation' => rand(100, 1000),
            ]);
          $n += 1;
            }

         $namesShips = [];
        do {
            $namesShips[] = $faker->firstNameMale;
            $namesShips = array_unique($namesShips);
        }while(count($namesShips) != 60);

        foreach($namesShips as $name){
            DB::table('ships')->insert([
                'ship_name' => $name,
                'country_id' => rand(1, count($states)),
            ]);
        }
     
  
        
    }
}
