<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la taula likes.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('image_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();

            // Evita que un usuari pugui fer like dues vegades a la mateixa imatge
            $table->unique(['user_id', 'image_id']);
        });
    }

    /**
     * Elimina la taula likes.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};