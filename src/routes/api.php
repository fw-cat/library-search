<?php

use App\Http\Controllers\Library\Api\GeolocationControoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/geo", [GeolocationControoler::class, "get"])->name("api.geolocation.get");
