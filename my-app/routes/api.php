<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;


Route::get('/user', function (Request $request) {
    return response()->json(
        [
            'id' => $request->user()->id,
            'role' => $request->user()->role,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'email' => $request->user()->email,
            'exercises_count' => $request->user()->exercises_count,
        ]);
    })->middleware('auth:sanctum');


Route::get('/exercises', [ExerciseController::class, 'index']);
Route::get('/exercises/{exercise}', [ExerciseController::class, 'show']);
Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy']) -> middleware('auth:sanctum');
Route::put('/exercises/{exercise}', [ExerciseController::class, 'update']) -> middleware('auth:sanctum');
Route::post('/exercises', [ExerciseController::class, 'store']) -> middleware('auth:sanctum');
Route::get('/exercises/categories/{exercise}', [ExerciseController::class, 'showExerciseCategories']);


Route::get('/users', [Usercontroller::class, 'index']);
Route::get('/users/{user}', [Usercontroller::class, 'show']);
Route::delete('/users/{user}', [Usercontroller::class, 'destroy']) -> middleware('auth:sanctum');
Route::put('/users/{user}', [Usercontroller::class, 'update']) -> middleware('auth:sanctum');


Route::put('/users/profile/{user}', [Usercontroller::class, 'update']) -> middleware('auth:sanctum');


Route::get('/cards', [CardController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']) -> middleware('auth:sanctum');
Route::put('/categories/{category}', [CategoryController::class, 'update']) -> middleware('auth:sanctum');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']) -> middleware('auth:sanctum');
