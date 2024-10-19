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
        Schema::create('estado_incidente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 10)->unique();
            $table->timestamps();
        });

        Schema::create('severidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 15)->unique();
            $table->timestamps();
        });

        Schema::create('categoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 35)->unique();
            $table->timestamps();
        });

        Schema::create('incidencia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 200)->nullable();
            $table->date('fecha_reporte');
            $table->date('fecha_cierre')->nullable();
            $table->boolean('estado')->default(true);
            $table->foreignId('estado_incidente_id')->default(1)
                ->constrained('estado_incidente') // Constrained sin pasar indexName
                ->cascadeOnDelete();

            // Clave foránea sin valor por defecto
            $table->foreignId('severidad_id')
                ->constrained('severidad') // Sin indexName
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained('categoria') // Sin indexName
                ->cascadeOnDelete();

            // Clave foránea con valor por defecto 1 (asegúrate de que haya un registro con id 1 en usuario)
            $table->foreignId('usuario_reporte_id')->default(1)
                ->constrained('usuario', 'id') // Especificar la tabla y la columna si es necesario
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_incidente');
        Schema::dropIfExists('severidad');
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('incidencia');
    }
};
