<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mine;
use App\Models\Country;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mine>
 */
class MineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Mine::class;
    public function definition()
    {


        do{
            $n = rand(1, 359);
        }while (Mine::where('latitude', $n)->count() >= 359);

        do{
            $m = rand(1, 359);
        }while (Mine::where('latitude', $n)->where('longitude', $m)->count() == 1);

        return [
            'latitude' => $n,
            'longitude' => $m,
            'mine_name' => fake()->unique()->firstNameMale,
            'country_id' => rand(1, Country::count()),
            'exploitation' => rand(1000, 10000),
        ];
    }
}
