<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);


Route::get('/genres', [GenreController::class, 'index']);
Route::post('/genres', [GenreController::class, 'store']);



Route::get('/authors', [AuthorsController::class, 'index']);
Route::post('/authors', [AuthorsController::class, 'store']);
