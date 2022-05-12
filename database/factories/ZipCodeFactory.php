<?php

namespace Database\Factories;

use App\Models\FederalEntity;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZipCode>
 */
class ZipCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'zip_code' => $this->faker->randomNumber(5, false),
            'locality' => $this->faker->word(),
            'federal_entity_id' => FederalEntity::factory(),
            'municipality_id' => Municipality::factory(),
        ];
    }
}
