<?php

namespace Database\Seeders;
use DB;
use App\Models\Country;
use App\Models\Ship;
use App\Models\Mine;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;



class DatabaseSeeder extends Seeder
{

    public function run()
    {
        Country::factory()
        ->count(15)
        ->create()
        ->each(function ($country){
            Mine::factory()->hasAttached(
                Ship::factory()->count(3)->create(['country_id'=>$country->id])
                )
                ->count(3)->create(['country_id'=>$country->id]);
            });
            
            
            $alliancesNames = ['United countries alliance', 'Common wealth alliance', 'Internecine assistance alliance'];
            foreach($alliancesNames as $name){
                DB::table('alliances')->insert([
                    'alliance_name' => $name,
                ]);
            }
            DB::table('users')->insert([
                'name' => 'admin',
                'email'=> 'admin@example.com',
                'password'=> Hash::make('123'),
            ]);
        // Ship::factory()->count(60)->create();
        // $faker = Factory::create();

        // foreach(range(1,10) as $_){
        // DB::table('countries')->insert([
        //     'country_name' => $faker->unique()->state,
        //     'amount_of_mines' => rand(1, 50),
        // ]);
        // }

        // static $n = 0;
        // foreach(range(1,30) as $_){
        //     DB::table('mines')->insert([
        //         'latitude' => $n,
        //         'longitude' => $n,
        //         'mine_name' => $faker->unique()->firstNameFemale,
        //         'country_id' => rand(1, count($states)),
        //         'exploitation' => rand(100, 1000),
        //     ]);
        //   $n += 1;
        //     }

        // foreach(range(1,60) as $_){
        //     DB::table('ships')->insert([
        //         'ship_name' => $faker->unique()->firstNameMale,
        //         'country_id' => rand(1, count($states)),
        //     ]);
        // }

        //////// $this->call(MineSeeder::class);
        //////// $this->call(ShipSeeder::class);
     
  
        
    }
}
