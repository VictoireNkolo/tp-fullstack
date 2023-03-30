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
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'type' => $this->faker->randomElement(['Maison', 'Appartement', 'Parking']),
            'description' => $this->faker->text(150)
        ];
    }
}


