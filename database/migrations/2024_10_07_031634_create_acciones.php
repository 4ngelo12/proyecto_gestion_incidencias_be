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
        Schema::create('acciones', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->string('imagen', length: 200)->nullable();
            $table->date('fecha_accion');
            $table->boolean('estado')->default(true);
            $table->foreignId('incidencia_id')->constrained(table: 'incidencia', indexName: 'fk_incidencias')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained(table: 'usuario', indexName: 'fk_usuario')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones');
    }
};
