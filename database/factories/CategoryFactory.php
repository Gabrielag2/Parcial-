<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->text(),
            'description' => $this->faker->text(),
            'tradiciones' =>$this->faker->text(),
            'nombre' => $this->faker->text(),
            'descripcion' => $this->faker->text(),
            'precio' => $this->faker->integer(),




        ];
    }
}
