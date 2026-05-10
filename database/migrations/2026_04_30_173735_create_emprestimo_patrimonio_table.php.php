<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emprestimo_patrimonio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('emprestimo_id')
                ->constrained('emprestimos')
                ->cascadeOnDelete();

            $table->foreignId('patrimonio_id')
                ->constrained('patrimonios')
                ->cascadeOnDelete();

            $table->date('data_emprestimo');
            $table->date('data_devolucao');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprestimo_patrimonio');
    }
};