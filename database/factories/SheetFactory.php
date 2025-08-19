<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'a'から'j'までのランダムなアルファベット1文字を生成
            'row' => $this->faker->randomElement(['a', 'b', 'c', 'd', ]),
            // 1から20までのランダムな整数を生成
            'column' => $this->faker->numberBetween(1, 20),
        ];
    }
}