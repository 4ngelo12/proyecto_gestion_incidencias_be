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
            $table->string('nombre', length: 10)->unique();
            $table->timestamps();
        });

        Schema::create('severidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 15)->unique();
            $table->timestamps();
        });

        Schema::create('categoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 35)->unique();
            $table->timestamps();
        });

        Schema::create('incidencia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 50);
            $table->text('descripcion')->nullable();
            $table->string('imagen', length: 200)->nullable();
            $table->date('fecha_reporte');
            $table->date('fecha_cierre')->nullable();
            $table->boolean('estado')->default(true);
            $table->foreignId('estado_incidente_id')->constrained(table: 'estado_incidente', indexName: 'estado_incidente_id')->cascadeOnDelete();
            $table->foreignId('severidad_id')->constrained(table: 'severidad', indexName: 'severidad_id')->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained(table: 'categoria', indexName: 'categoria_id')->cascadeOnDelete();
            $table->foreignId('usuario_reporte_id')->constrained(table: 'usuario', indexName: 'fk_usuario_reporte')->cascadeOnDelete();
            $table->foreignId('usuario_asignado_id')->constrained(table: 'usuario', indexName: 'fk_usuario_asignado')->cascadeOnDelete();
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
