<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanBookController;
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

Route::controller(AuthController::class)->group(function ($router) {
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout')->middleware('auth.token');
    Route::post('refresh', 'refresh')->name('refresh');
});


Route::middleware('auth.token')->group(function() {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('author', AuthorController::class);
    Route::apiResource('book', BookController::class);
    Route::apiResource('loanbook', LoanBookController::class);

    // Route::post('/send', [ContactController::class, 'store'])->name('send');

});

