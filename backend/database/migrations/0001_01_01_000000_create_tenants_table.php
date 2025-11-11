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
        //Tenants = Empresas
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('siglas', 10)->unique();
            $table->string('nombre', 191);              // Nombre de la empresa
            $table->string('razon_social', 191)->nullable();
            $table->string('ruc', 11)->unique();
            $table->string('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
