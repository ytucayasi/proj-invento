<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('dni', 8);
            $table->string('apellido_paterno', 30);
            $table->string('apellido_materno', 30);
            $table->date('fecha_nacimiento');
            $table->char('genero', 1);
            $table->char('tipo_persona', 1);
            $table->char('area_id', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
