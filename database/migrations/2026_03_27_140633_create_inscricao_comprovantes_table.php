<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricao_comprovantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscricao_id')
                ->constrained('inscricoes')
                ->cascadeOnDelete();

            $table->string('arquivo');
            $table->string('nome_original')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricao_comprovantes');
    }
};
