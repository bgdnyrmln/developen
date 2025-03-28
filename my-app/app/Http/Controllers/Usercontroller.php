<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Usercontroller extends Controller
{
    public function create()
    {
        return view('register');
    }


    public function store()
    {
        $ValidatedAttributes = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::create($ValidatedAttributes);

        Auth::login($user);

        return redirect('/cars');
    }
}
