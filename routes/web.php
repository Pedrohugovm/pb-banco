<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\ContasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimentacoesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



Route::resource('/pessoas', PessoasController::class);
Route::post('/pessoas-update', [PessoasController::class, 'update'])->name('pessoas.update');


Route::resource('/contas', ContasController::class);
Route::post('/contas-update', [ContasController::class, 'update'])->name('contas.update');

Route::resource('/movimentacoes', MovimentacoesController::class);
Route::post('/movimentacoes-update', [MovimentacoesController::class, 'update'])->name('movimentacoes.update');
Route::get('/movimentacoes/{id}/atualizaTabela', [AjaxController::class, 'atualizaTabela'])->name('atualizaTabela');
Route::get('/movimentacoes/{id}/atualizaSelect', [AjaxController::class, 'atualizaSelect'])->name('atualizaSelect');


