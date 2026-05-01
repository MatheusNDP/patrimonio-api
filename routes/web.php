<?php

use App\Http\Controllers\EstabelecimentoController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\EmprestimoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('estabelecimentos.index');
});

Route::resource('estabelecimentos', EstabelecimentoController::class);

Route::resource('patrimonios', PatrimonioController::class);

Route::resource('emprestimos', EmprestimoController::class)->only([
    'index',
    'create',
    'store',
    'show',
    'destroy',
]);