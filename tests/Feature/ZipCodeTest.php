<?php

namespace Tests\Feature;

use App\Models\Settlement;
use App\Models\ZipCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/zip-codes';

    /** @test */
    public function it_return_404_when_the_given_zip_code_is_incorrect()
    {
        $this->getJson("{$this->endpoint}/bsjbjbej")
            ->assertStatus(404);
    }

    /** @test */
    public function it_return_the_given_code()
    {
        $zipCode = ZipCode::factory()->create([
            'zip_code' => 72000,
            'locality' => 'ZOO',
        ]);

        $settlement1 = Settlement::factory()->for($zipCode, 'zipCode')->create([
            'name' => 'FOO',
        ]);

        $settlement2 = Settlement::factory()->for($zipCode, 'zipCode')->create([
            'name' => 'ZOO',
        ]);

        $settlement3 = Settlement::factory()->for($zipCode, 'zipCode')->create([
            'name' => 'VAR',
        ]);

        $this->getJson("{$this->endpoint}/{$zipCode->zip_code}")
            ->assertOk()
            ->assertJson([
                'zip_code' => $zipCode->zip_code,
                'locality' => $zipCode->locality,
                'settlements' => [
                    [
                        'name' => $settlement1->name,
                    ],
                    [
                        'name' => $settlement2->name,
                    ],
                    [
                        'name' => $settlement3->name,
                    ],
                ],
            ],
        );
    }
}
