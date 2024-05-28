<?php

use App\Http\Controllers\Book\SearchController as BookSearchController;
use App\Http\Controllers\Library\SearchController as LibrarySearchController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, "top"])->name("top");
Route::get('/search/zip', [LibrarySearchController::class, "zip"])->name("search.zip");
Route::get('/system/{system_id}/libary/{libkey}/book/', [BookSearchController::class, "search"])->name("search.book");

Route::post('/system/{system_id}/libary/{libkey}/book/', [BookSearchController::class, "result"])->name("search.book.result");
