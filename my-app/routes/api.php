<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\Usercontroller;

Route::get('/user', function (Request $request) {
    return response()->json(
        [
            'role' => $request->user()->role,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email
        ]);
    })->middleware('auth:sanctum');




Route::get('/users', [Usercontroller::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);

Route::get('/exercises/{exercise}', [ExerciseController::class, 'show']);

Route::get('/users/{user}', [Usercontroller::class, 'show']);
Route::delete('/users/{user}', [Usercontroller::class, 'destroy'])->middleware('auth:sanctum');
