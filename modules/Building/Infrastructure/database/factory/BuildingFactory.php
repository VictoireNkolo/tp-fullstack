<?php

namespace Module\Infrastructure\Building\database\factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;

class BuildingFactory extends Factory
{
    protected $model = Building::class;


    public function definition(): array
    {
        $company = Company::factory()->create();
        return [
            'uuid' => $this->faker->uuid,
            'company_id' => $company->id,
            'company_uuid' => $company->uuid,
            'address_line1' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'is_active' => true,
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['Maison', 'Appartement', 'Parking']),
            'description' => $this->faker->text(500),
            'buy_date' => $this->faker->date('Y-m-d'),
            'tantieme' => $this->faker->randomNumber(),
            'equipment' => $this->faker->text
        ];
    }
}


