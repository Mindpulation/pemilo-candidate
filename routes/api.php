<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

// Route::get('Candidate', 'App\Http\Controllers\apicontroller@index');

Route::post('getAllCandidate', [ApiController::class, 'index']);
Route::post('getCandidate', [ApiController::class, 'shows']);
Route::post('Candidate', [ApiController::class, 'create']);
// Route::put('Candidate/{id}', [ApiController::class, 'update']);
Route::put('Candidate', [ApiController::class, 'update']);
Route::delete('Candidate', [ApiController::class, 'drop']);
Route::post('getRoom', [ApiController::class, 'room']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
