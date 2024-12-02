<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uri')->unique(); // URI de Spotify (Álbum)
            $table->string('artist_uri'); // Asegúrate de que esto sea un string
            $table->year('release_year')->nullable();
            $table->string('cover_art')->nullable(); // URL de la portada
            $table->timestamps();
        
            // Establece la clave foránea después de definir la columna
            $table->foreign('artist_uri')->references('uri')->on('artistas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
