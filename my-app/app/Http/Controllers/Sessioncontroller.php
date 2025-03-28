<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Sessioncontroller extends Controller
{
    public function create()
    {
        return view('login');
    }


    public function store()
    {
        $ValidatedAttributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (! Auth::attempt($ValidatedAttributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.',
                'password' => 'Your provided credentials could not be verified.'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/cars');
    }


    public function destroy()
    {
        Auth::logout();
        return redirect('/cars');
    }
}
