<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogAcessoMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Use "Route::prefix('/agrupamento')->group(function(){}" para criar um agrupamento
// Use "->name('pagina-nome');" para nomear uma rota
// Use "Route::get('/pagina', [App\Http\Controllers\Classe::class, 'funcaoClasse'])" para criar uma rota.
// Lembre-se de utilizar os metods http quando necessario, como POST.

Route::prefix('/test')->group(function(){
    Route::get('/exemplo', [App\Http\Controllers\ExemploController::class, 'exemplo'])->name('pagina-exemplo');
});