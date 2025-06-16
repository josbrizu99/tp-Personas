<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\NacionalidadController;
use App\Http\Controllers\Api\PersonasDireccionController;
use App\Http\Controllers\Api\PersonasTelefonoController;
use App\Http\Controllers\Api\PersonasTrabajoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_middleware', 'jetstream')
])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::apiResource('personas', PersonaController::class);
Route::apiResource('nacionalidades', NacionalidadController::class);
Route::apiResource('personas-direcciones', PersonasDireccionController::class);
Route::apiResource('personas-telefonos', PersonasTelefonoController::class);
Route::apiResource('personas-trabajos', PersonasTrabajoController::class); 