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
            
            // Información del cargo
            $table->string('funcion', 100);
            $table->enum('jerarquia', [
                'Comisario Inspector',
                'Comisario',
                'Subcomisario',
                'Principal',
                'Inspector',
                'Subinspector',
                'Oficial',
                'Sargento',
                'Cabo',
                'Agente'
            ]);
            
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
            $table->string('lugar_trabajo', 200);
            $table->unsignedInteger('numero_despacho')->nullable();
            $table->date('fecha_ingreso');
            $table->enum('situacion_revista', [
                'Activo',
                'Retiro',
                'Pasiva'
            ])->default('Activo');
            
            // Datos del armamento
            $table->string('marca_arma', 100)->nullable();
            $table->string('numero_arma', 100)->nullable();
            
            // Auditoría temporal
            $table->timestamps();
            $table->softDeletes();
            
            // Índices compuestos para búsquedas comunes
            $table->index(['apellido', 'nombre']);
            $table->index('situacion_revista');
            $table->index('lugar_trabajo');
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
