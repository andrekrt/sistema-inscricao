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
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->string('dojo_nome');
            $table->string('sensei_nome');
            $table->string('telefone');
            $table->string('email')->nullable();
            $table->string('comprovante');
            $table->enum('status', ['pendente', 'pago', 'confirmado', 'cancelado'])
                ->default('pendente');
            $table->unsignedInteger('total_atletas')->default(0);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};
