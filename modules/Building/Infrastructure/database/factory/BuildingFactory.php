<?php

namespace TP\Building\Infrastructure\database\factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use TP\Building\Infrastructure\Models\Building;

class BuildingFactory extends Factory
{
    protected $model = Building::class;


    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'is_active' => true,
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['Maison', 'Appartement', 'Parking']),
            'description' => $this->faker->text(500)
        ];
    }
}


