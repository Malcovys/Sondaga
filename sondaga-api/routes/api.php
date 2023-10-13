<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SondageController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Broadcast;

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

Route::prefix('/sondage')->name('sondage.')->group(function () {

    Route::get('/', [SondageController::class, 'getSondagesWithVotes']);
    Route::delete('/remove/{id}-{uid}', [SondageController::class, 'removeSondage']);

    Route::post('/save', [SondageController::class, 'createSondage']);

    Route::post('/vote', [SondageController::class, 'createVote']);
});

Route::post('/singup', [UserController::class, 'singUp']);
Route::post('/login', [UserController::class, 'auth']);