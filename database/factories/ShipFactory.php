<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ship;
use App\Models\Country;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ship>
 */
class ShipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ship::class;

    public function definition()
    {
  
        return [
            'ship_name' => fake()->unique()->firstNameFemale,
            'country_id' => rand(1, Country::count()),
        ];
    }
}
