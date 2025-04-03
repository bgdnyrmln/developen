<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sessioncontroller;
use App\Http\Controllers\ExerciseController;


Route::get('/user', function(){
    return response() -> json("Hello World");
})->middleware('auth:sanctum');

Route::get('/users', [Sessioncontroller::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);

