<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Genera una definició de comentari fals.
     */
    public function definition(): array
    {
        return [
            'user_id'  => User::factory(),
            'image_id' => Image::factory(),
            'body'     => fake()->paragraph(),
        ];
    }
}