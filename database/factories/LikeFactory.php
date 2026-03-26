<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Genera una definició de like fals.
     */
    public function definition(): array
    {
        return [
            'user_id'  => User::factory(),
            'image_id' => Image::factory(),
        ];
    }
}