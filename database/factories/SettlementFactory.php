<?php

namespace Database\Factories;

use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\ZipCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settlement>
 */
class SettlementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => $this->faker->unique()->randomNumber(5, false),
            'name' => $this->faker->word(),
            'zone_type' => $this->faker->randomElement([Settlement::ZONE_TYPE_URBANO, Settlement::ZONE_TYPE_RURAL]),
            'settlement_type_id' => SettlementType::factory(),
            'zip_code_id' => ZipCode::factory(),
        ];
    }
}
