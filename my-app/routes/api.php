<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sessioncontroller;
use App\Http\Controllers\ExerciseController;


Route::get('/user', function (Request $request) {
    return response()->json(
        [
            'role' => $request->user()->role,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email
        ]);
    })->middleware('auth:sanctum');




Route::get('/users', [Sessioncontroller::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);

<<<<<<< HEAD

Route::get('/exercises/{exercise}', [ExerciseController::class, 'show']);
=======
>>>>>>> parent of 2543cfd (commint)
