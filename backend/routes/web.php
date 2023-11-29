<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TrackController;
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
//Route::view('swagger', 'swagger');

Route::resource('player', PlayerController::class);

Route::resource('tracks', TrackController::class);

Route::resource('artists', ArtistController::class);

Route::get('api/getaudio/{folder}/{filename}/{ext}', [TrackController::class, 'listenAudio', 'as' => 'audio']);//FIXME delete here
Route::get('api/tracks/search', [TrackController::class, 'search']);//FIXME delete here

Route::get('/getAjax', [ArtistController::class, 'getAjax'])->name('getAjax');

//Route::get('/', function () {
//    return redirect()->away(ENV('FRONT_URL'));
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
