<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\JsonResponse;

/**
 * LikeController - 
 * @return's JSON ja que les dades son processades amb JS posteriorment.
 * */ 
class LikeController extends Controller
{
    /**
     * Fa o desfà el like d'una imatge (toggle).
     */
    public function toggle(Image $image): JsonResponse
    {
        $userId = auth()->id();

        // Comprovem si ja existeix el like
        $like = $image->likes()->where('user_id', $userId)->first();

        if ($like) {
            // Si ja existeix, l'eliminem
            $like->delete();
            $liked = false;
        } else {
            // Si no existeix, el creem
            $image->likes()->create([
                'user_id' => $userId,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked'      => $liked,
            'like_count' => $image->likes()->count(),
        ]);
    }
}