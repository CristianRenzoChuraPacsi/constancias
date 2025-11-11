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
        Schema::create('asistencia_docentes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->integer('cantidad_horas')->default(40);
            $table->timestamps();

            //id_docente
            $table->unsignedBigInteger('docente_id')->nullable();
            $table->foreign('docente_id')->references('id')->on('docentes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_docentes');
    }
};
