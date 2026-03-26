<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Pobla la base de dades amb dades de prova.
     */
    public function run(): void
    {
        // Creem 10 usuaris
        $users = User::factory(10)->create();

        // Per cada usuari creem les seves imatges
        foreach ($users as $user) {

            // Cada usuari tindrà entre 3 i 6 imatges
            $images = Image::factory(rand(3, 6))->create([
                'user_id' => $user->id,
            ]);

            // Per cada imatge creem comentaris i likes
            foreach ($images as $image) {

                // Cada imatge tindrà entre 2 i 5 comentaris
                // d'usuaris aleatoris
                Comment::factory(rand(2, 5))->create([
                    'image_id' => $image->id,
                    'user_id'  => $users->random()->id,
                ]);

                // Cada imatge tindrà likes d'usuaris aleatoris
                // usem shuffle per evitar duplicats (unique per user_id + image_id)
                $likers = $users->shuffle()->take(rand(2, 8));
                foreach ($likers as $liker) {
                    Like::factory()->create([
                        'image_id' => $image->id,
                        'user_id'  => $liker->id,
                    ]);
                }
            }
        }
    }
}
