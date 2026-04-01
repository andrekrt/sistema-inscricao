<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->string('tipo_disputa')->default('individual')->after('tipo');
            $table->unsignedTinyInteger('min_atletas_equipe')->nullable()->after('tipo_disputa');
            $table->unsignedTinyInteger('max_atletas_equipe')->nullable()->after('min_atletas_equipe');
        });

        DB::table('categorias')->update([
            'tipo_disputa' => 'individual',
        ]);
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_disputa',
                'min_atletas_equipe',
                'max_atletas_equipe',
            ]);
        });
    }
};
