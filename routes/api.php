<?php

use App\Http\Controllers\ProjetoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/projetos', [ProjetoController::class, 'index']);
Route::prefix('/projeto')->group(function () {
    Route::get('/{id}', [ProjetoController::class, 'show']);
    Route::post('/store', [ProjetoController::class, 'store']);
    Route::put('/{id}', [ProjetoController::class, 'update']);
    Route::delete('/{id}', [ProjetoController::class, 'destroy']);
});
