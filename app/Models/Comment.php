<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * Camps assignables en massa.
     */
    protected $fillable = [
        'user_id',
        'image_id',
        'body',
    ];

    /**
     * Obté l'usuari propietari del comentari.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obté la imatge a la qual pertany el comentari.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
