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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El dueño del espacio
            $table->string('name'); // Ejemplo: "Trabajo"
            $table->string('slug'); // Ejemplo: "trabajo" (para la URL)
            $table->string('icon')->default('briefcase'); // Icono por defecto
            $table->string('color')->nullable(); // Por si quieres darle colores
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
