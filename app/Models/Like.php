<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * Camps assignables en massa.
     */
    protected $fillable = [
        'user_id',
        'image_id',
    ];

    /**
     * Obté l'usuari que ha fet el like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obté la imatge a la qual pertany el like.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
