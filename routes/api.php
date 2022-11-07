<?php

use App\Http\Controllers\ExternalApiController;
use App\Http\Controllers\v1\BookController;
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



/// Get Book Route
Route::group(['prefix' => 'v1'], function() {
    Route::get('/books', [BookController::class,'index']);
    Route::get('/books/{id}', [BookController::class,'getById']);
    Route::post('/books', [BookController::class,'store']);
    Route::patch('/books/{id}', [BookController::class,'update']);
    Route::delete('/books/{id}', [BookController::class,'destroy']);
});


Route::get('/external-books', [ExternalApiController::class,'searchByName']);


Route::fallback( function(){
    return 'Page not found';
});
