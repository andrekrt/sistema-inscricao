<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->string('token_edicao')->nullable()->unique()->after('comprovante');
            $table->boolean('edicao_liberada')->default(true)->after('token_edicao');
            $table->timestamp('edicao_ate')->nullable()->after('edicao_liberada');
        });
    }

    public function down(): void
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->dropColumn([
                'token_edicao',
                'edicao_liberada',
                'edicao_ate',
            ]);
        });
    }
};
