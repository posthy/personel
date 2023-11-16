<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/person', [PersonController::class, 'index']);
Route::get('/person/{id}', [PersonController::class, 'show']);
Route::post('/person', [PersonController::class, 'store']);
Route::put('/person/{id}', [PersonController::class, 'update']);
Route::delete('/person/{id}', [PersonController::class, 'delete']);

Route::get('/person/{id}/address', [AddressController::class, 'index']);
Route::get('/person/{id}/address/{type}', [AddressController::class, 'show']);
Route::post('/person/{id}/address', [AddressController::class, 'store']);
Route::put('/person/{id}/address/{type}', [AddressController::class, 'update']);
Route::delete('/person/{id}/address/{type}', [AddressController::class, 'delete']);

Route::get('/person/{id}/contact', [ContactController::class, 'index']);
Route::get('/person/{id}/contact/{contact_id}', [ContactController::class, 'show']);
Route::post('/person/{id}/contact', [ContactController::class, 'store']);
Route::put('/person/{id}/contact/{contact_id}', [ContactController::class, 'update']);
Route::delete('/person/{id}/contact/{contact_id}', [ContactController::class, 'delete']);