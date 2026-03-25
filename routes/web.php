<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InscricaoAdminController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\ProfileController;
use App\Models\Categoria;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de inscrição
Route::get('/inscricao', [InscricaoController::class, 'create'])->name('inscricao.create');
Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');
Route::get('/inscricao/sucesso', [InscricaoController::class, 'success'])->name('inscricao.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // rotas de categorias
    Route::resource('categorias', CategoriaController::class);

    // Rotas de dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Rotas painel de inscrições
    Route::get('/inscricoes',[InscricaoAdminController::class, 'index'])->name('inscricoes.index');
    Route::get('/inscricoes/{inscricao}', [InscricaoAdminController::class, 'show'])->name('inscricoes.show');
    Route::patch('/inscricoes/{inscricao}', [InscricaoAdminController::class, 'updateStatus'])->name('inscricoes.updateStatus');
    Route::get('/inscricoes-exportar', [InscricaoAdminController::class, 'export'])->name('inscricoes.export');
});

require __DIR__ . '/auth.php';
