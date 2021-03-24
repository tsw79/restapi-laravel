<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\ActorController;
use App\Http\Controllers\API\MovieActorController;
use App\Http\Controllers\API\MovieActorRelatedController;
use App\Http\Controllers\API\ReviewController;

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

Route::middleware('auth:api')->prefix('v1')->group(function() {

    /*
     * User routes
     */
    Route::get('/users', function (Request $request) {
        return $request->user();
    });


    /*
     * Movie routes
     */
    Route::apiResource('/movies', MovieController::class);

    Route::get('/movies/{movie}/relationships/actors', '\App\Http\Controllers\API\MovieActorController@index')
        ->name('movies.relationships.actors');

    Route::put('/movies/{movie}/relationships/actors', '\App\Http\Controllers\API\MovieActorController@update')
        ->name('movies.relationships.actors');

    Route::get('/movies/{movie}/actors', '\App\Http\Controllers\API\MovieActorRelatedController@index')
        ->name('movies.actors');

    /*
     * Actor routes
     */
    Route::apiResource('/actors', ActorController::class);

    /*
     * Review routes
     */
    Route::apiResource('/reviews', ReviewController::class);
});

// Auth routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/signin', [AuthController::class, 'signin']);
