<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email', 150)->unique();
            $table->string('token', 65);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};