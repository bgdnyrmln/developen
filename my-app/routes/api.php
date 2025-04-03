<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sessioncontroller;
use App\Http\Controllers\ExerciseController;
use App\Models\User;
use Illuminate\Contracts\Session\Session;

Route::get('/user', function (Request $request) {
    return response()->json(["asd"
    ]);
})->middleware('auth:sanctum');;

Route::get('/users', [Sessioncontroller::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);

