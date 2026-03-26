<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Genera una definició d'imatge falsa.
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'image_path'  => 'images/' . fake()->image(
                                storage_path('app/public/images'),
                                640,
                                480,
                                null,
                                false
                             ),
            'description' => fake()->sentence(),
        ];
    }
}