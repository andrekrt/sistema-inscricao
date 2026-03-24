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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // fukugo, kata, kumite, tira_fita, kihon_ippon
            $table->string('nome');
            $table->unsignedTinyInteger('idade_min');
            $table->unsignedTinyInteger('idade_max');
            $table->enum('sexo', ['M', 'F']);
            $table->string('faixa_inicial');
            $table->string('faixa_final');
            $table->string('especial')->nullable(); // pcd, master
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
