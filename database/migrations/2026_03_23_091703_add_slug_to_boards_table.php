<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('boards', function (Blueprint $table) {
        // Añadimos la columna slug después del nombre
        $table->string('slug')->after('name')->unique()->nullable();
    });
}

public function down(): void
{
    Schema::table('boards', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
};
