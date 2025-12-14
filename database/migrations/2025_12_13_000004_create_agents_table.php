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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            
            // Relaciones con tablas catálogo (Normalización)
            $table->foreignId('job_function_id')
                ->constrained('job_functions')
                ->onDelete('restrict')
                ->comment('Función del agente');
            
            $table->foreignId('hierarchy_id')
                ->constrained('hierarchies')
                ->onDelete('restrict')
                ->comment('Jerarquía policial');
            
            // Datos personales
            $table->string('apellido', 100)->index(); // Índice para búsquedas frecuentes
            $table->string('nombre', 100);
            $table->string('dni', 20)->unique()->index(); // Unique + Index para búsquedas optimizadas
            $table->string('legajo', 50)->unique();
            $table->string('cuil_cuit', 15);
            $table->date('fecha_nacimiento');
            $table->string('grupo_sanguineo', 10)->nullable();
            
            // Datos de contacto
            $table->text('domicilio_actual');
            $table->string('telefono', 20)->nullable();
            $table->string('correo_electronico', 150)->nullable();
            
            // Datos laborales
            $table->foreignId('workplace_id')
                ->constrained('workplaces')
                ->onDelete('restrict')
                ->comment('Lugar de trabajo del agente');
            
            $table->unsignedInteger('numero_despacho')->nullable();
            $table->date('fecha_ingreso');
            $table->enum('situacion_revista', [
                'Activo',
                'Retiro',
                'Pasiva'
            ])->default('Activo')->index();
            
            // Datos del armamento
            $table->string('marca_arma', 100)->nullable();
            $table->string('numero_arma', 100)->nullable();
            
            // Auditoría temporal
            $table->timestamps();
            $table->softDeletes();
            
            // Índices compuestos para búsquedas comunes
            $table->index(['apellido', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
