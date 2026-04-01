<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscricao_id')
                ->constrained('inscricoes')
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnDelete();

            $table->longText('nomes_atletas');
            $table->unsignedTinyInteger('quantidade_atletas')->default(0);

            $table->timestamps();

            $table->unique(['inscricao_id', 'categoria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipes');
    }
};
