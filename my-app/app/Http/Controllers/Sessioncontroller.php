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
    public function create()
    {
        return view('login');
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedAttributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Try to find the user by email
        $user = User::where('email', $validatedAttributes['email'])->first();

        // If the user does not exist or password does not match, throw an exception
        if (!$user || !Hash::check($validatedAttributes['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.',
                'password' => 'Your provided credentials could not be verified.'
            ]);
        }

        $request->session()->regenerate();

        // Issue a token using Sanctum
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Return the token to the frontend for authentication
        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $token, // Return token to the frontend
            'user' => $user,   // Optionally include the user data in the response
        ], 200);
    }








    public function destroy()
    {
        Auth::logout();
        return redirect('/cars');
    }
}
