<?php

use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Carcontroller;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\Sessioncontroller;
use App\Http\Controllers\ExerciseController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

Route::view('/', 'welcome');



Route::get('/users', [UserController::class, 'index']);

Route::get('/exercises', [ExerciseController::class, 'index']);



Route::get('/cars', [Carcontroller::class, 'index']);
Route::get('/cars/create', [Carcontroller::class, 'create']) -> middleware('auth');
Route::post('/cars', [Carcontroller::class, 'store']);
Route::get('/cars/{car}', [Carcontroller::class, 'show']);
Route::get('/cars/{car}/edit', [Carcontroller::class, 'edit']) -> middleware(['auth', 'can:edit-car,car']);
Route::patch('/cars/{car}', [Carcontroller::class, 'update']);
Route::delete('/cars/{car}', [Carcontroller::class, 'destroy']);


// Route::post('/login', [SessionController::class, 'store']);
