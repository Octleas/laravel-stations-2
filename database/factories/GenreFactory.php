<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ジャンル名をランダムなユニークな単語で生成
            'name' => $this->faker->unique()->word(),
        ];
    }
}