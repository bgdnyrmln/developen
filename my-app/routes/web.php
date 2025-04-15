<?php

use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\ExerciseController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

Route::view('/', 'welcome');
