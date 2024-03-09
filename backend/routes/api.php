<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrackController;
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
Route::post('register', [RegisterController::class, 'create']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth')->get('tracks/search', [TrackController::class, 'search']);
Route::middleware('auth')->get('tracks/fav', [TrackController::class, 'favorites']);
Route::middleware('auth')->post('tracks/like', [TrackController::class, 'setTrackFavorite']);
Route::middleware('auth')->post('tracks/unlike', [TrackController::class, 'setTrackUnfavorite']);

Route::get('getaudio/{folder}/{filename}/{ext}', [TrackController::class, 'listenAudio', 'as' => 'audio']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
