<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Country::class;

    public function definition()
    {   
        $alliance_id = [null, ...range(1,3)];

        return [
            'country_name' => fake()->unique()->state,
            'amount_of_mines' => rand(1, 50),
            'alliance_id' => $alliance_id[rand(0,3)],
        ];
    }
}
