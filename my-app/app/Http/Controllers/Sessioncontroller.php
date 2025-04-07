<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

class Sessioncontroller extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }








    public function destroy()
    {
        Auth::logout();
        return redirect('/cars');
    }
}
