<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UsersController;
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

//this is the endpoint with prefix /api
Route::post('/login', [UsersController::class, 'login']);
Route::post('/register', [UsersController::class, 'register']);

//modify this
//this group mean return user's data if authenticated successfully
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UsersController::class, 'index']);
    Route::post('/fav', [UsersController::class, 'storeFavDoc']);
    Route::post('/logout', [UsersController::class, 'logout']);
    Route::get('/appointments', [AppointmentsController::class, 'index']);
    Route::post('/book', [AppointmentsController::class, 'addApp']);
    Route::post('/cancel', [AppointmentsController::class, 'cancelApp']);
    Route::get('/get-reviews', [ReviewsController::class, 'index']);
    Route::post('/review', [ReviewsController::class, 'review']);
});


