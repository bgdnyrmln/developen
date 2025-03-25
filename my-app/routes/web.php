<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;

Route::get('/', function () {
    $cars = Car::all();
    dd($cars);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/cars', function () {
    $cars = Car::all();
    return view('cars', ['cars' => $cars]); // Proper way to pass data
});



Route::get('/cars/{car}', function ($car) {
    $car = Car::find($car); // Fetch car by ID
    if (!$car) {
        return view('error');
    }
    return view('car', ['car' => $car]);
});
