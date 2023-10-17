<?php

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

Route::post('/sent_wa', [App\Http\Controllers\WaController::class, 'sent_wa']);
Route::post('/sent_file', [App\Http\Controllers\WaController::class, 'sent_file']);
Route::post('/sent_wa_excel', [App\Http\Controllers\WaController::class, 'sent_wa_excel']);
Route::post('/sent_wa_json', [App\Http\Controllers\WaController::class, 'sent_wa_json']);
Route::post('/sent_file_json', [App\Http\Controllers\WaController::class, 'sent_file_json']);
Route::post('/cek_number', [App\Http\Controllers\WaController::class, 'cek_number']);
Route::post('/make_read', [App\Http\Controllers\WaController::class, 'make_read']);
Route::post('/inbox', [App\Http\Controllers\WaController::class, 'inbox']);
Route::post('/get_chat', [App\Http\Controllers\HistoryController::class, 'get_chat']);
// Route::get('/sent_wa_cek', [App\Http\Controllers\WaController::class, 'sent_wa_cek']);
// Route::get('/training_api', [App\Http\Controllers\ApiWaController::class, 'training_api']);
Route::get('/phpinfo', function() {
    return phpinfo();
});
