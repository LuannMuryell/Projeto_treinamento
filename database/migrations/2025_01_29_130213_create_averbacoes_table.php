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
        Schema::create('averbacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties', 'ins_municipal')->onDelete('cascade');
            $table->enum('evento', ['Aumento de Área Construída', 'Redução de Área Construída', 'Observação', 'Cancelamento', 'Reativação']);
            $table->float('medida', precision:2)->nullable();
            $table->string('descricao');
            $table->date('data_averbacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('averbacoes');
    }
};
