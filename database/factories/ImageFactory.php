<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{
    /**
     * Genera una definició d'imatge falsa.
     */
    public function definition(): array
    {
        // Descarreguem una imatge aleatòria de picsum
        $filename = Str::random(10) . '.jpg';
        $path = storage_path('app/public/images/' . $filename);

        $imageContent = file_get_contents('https://picsum.photos/640/480?random=' . rand(1, 1000));
        file_put_contents($path, $imageContent);

        return [
            'user_id'     => User::factory(),
            'image_path'  => 'images/' . $filename,
            'description' => fake()->sentence(),
        ];
    }
}