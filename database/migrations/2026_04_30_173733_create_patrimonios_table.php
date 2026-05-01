<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('codigo')->unique();
            $table->string('tipo');

            $table->date('data_entrada');

            $table->foreignId('estabelecimento_pai_id')
                ->constrained('estabelecimentos')
                ->cascadeOnDelete();

            $table->boolean('baixado')->default(false);
            $table->date('data_baixa')->nullable();
            $table->text('motivo_baixa')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patrimonios');
    }
};