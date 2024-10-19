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
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 15)->unique();
            $table->timestamps();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario', length: 50);
            $table->string('email', length: 150)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', length: 200);
            $table->boolean('estado')->default(true);
            $table->foreignId('rol_id')->constrained(table: 'rol', indexName: 'fk_roles')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('rol');
    }
};
