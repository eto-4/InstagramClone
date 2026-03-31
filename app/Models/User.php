<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Camps assignables en massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'avatar',
    ];

    /**
     * Camps ocults en serialització.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Càsting d'atributs.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obté les imatges de l'usuari.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Obté els comentaris de l'usuari.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Obté els likes de l'usuari.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}