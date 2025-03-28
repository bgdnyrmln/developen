<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;
use App\Http\Controllers\Carcontroller;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\Sessioncontroller;
use Illuminate\Support\Facades\Mail;

Route::view('/', 'welcome');

Route::get('test', function () {
    Mail::to('bgdnyrmln@gmail.com')->
    send(new \App\Mail\CarListed());
});



Route::get('/cars', [Carcontroller::class, 'index']);
Route::get('/cars/create', [Carcontroller::class, 'create']) -> middleware('auth');
Route::post('/cars', [Carcontroller::class, 'store']);
Route::get('/cars/{car}', [Carcontroller::class, 'show']);
Route::get('/cars/{car}/edit', [Carcontroller::class, 'edit']) -> middleware(['auth', 'can:edit-car,car']);
Route::patch('/cars/{car}', [Carcontroller::class, 'update']);
Route::delete('/cars/{car}', [Carcontroller::class, 'destroy']);


Route::get('/register', [Usercontroller::class, 'create']);
Route::post('/register', [Usercontroller::class, 'store']);


Route::get('/login', [Sessioncontroller::class, 'create']) -> name('login');
Route::post('/login', [Sessioncontroller::class, 'store']);
Route::post('/logout', [Sessioncontroller::class, 'destroy']);
