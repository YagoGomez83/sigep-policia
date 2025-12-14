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
        Schema::create('hierarchies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->unsignedTinyInteger('rank_level')->unique()->comment('Nivel de autoridad: 1=Mayor autoridad');
            $table->timestamps();
            
            // Índice para ordenamiento por jerarquía
            $table->index('rank_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hierarchies');
    }
};
