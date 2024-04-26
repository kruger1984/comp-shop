<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'        => $this->faker->company(),
            'thumbnail'    => $this->faker->fixturesImage('brands', 'images/brands'),
            'on_home_page' => $this->faker->boolean(),
            'sorting'      => $this->faker->numberBetween(1, 999),

        ];
    }
}
