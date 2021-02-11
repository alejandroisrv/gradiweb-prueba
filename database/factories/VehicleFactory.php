<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Owner;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model'=> ucfirst($this->faker->word()),
            'owner_id' => Owner::factory(),
            'vehicle_types_id' => VehicleType::factory(),
            'placa' =>  strtoupper(Str::random(6))
        ];
    }
}
