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
        Schema::create('properties', function (Blueprint $table) {
            $table->id('ins_municipal');
            $table->enum('tipo', ['Terreno', 'Casa', 'Apartamento']);
            $table->decimal('area_terreno', 10, 2)->nullable();
            $table->decimal('area_edificacao', 10, 2)->nullable();
            $table->string('logradouro', 255);
            $table->integer('numero');
            $table->string('bairro', 255);
            $table->string('complemento', 255)->nullable();
            $table->foreignId('contribuinte_id')->constrained('people')->onDelete('cascade');
            $table->enum('situacao', ['Ativo', 'Inativo'])->default('Ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
