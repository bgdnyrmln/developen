<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sessioncontroller;
use App\Http\Controllers\ExerciseController;


Route::get('/user', function (Request $request) {
    return response()->json(["yolo"]);
})->middleware('auth:sanctum');


Route::get('/users', [Sessioncontroller::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);


Route::get('/exercises/{exercise}', [ExerciseController::class, 'show']);