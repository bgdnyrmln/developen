<?php

namespace App\Http\Controllers;
use App\Mail\CarListed;
Use App\Models\Car;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Carcontroller extends Controller
{
    public function index()
    {
        $cars = Car::with('driver')->latest()->simplePaginate(5);
        return view('cars',
            ['cars' => $cars]
    ); // Proper way to pass data
    }


    public function create()
    {
        return view('create');
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'model' => 'required'
        ]);

        $car = new Car();
        $car->name = request('name');
        $car->model = request('model');
        $car->driver_id = 1;
        $car->save();
        Mail::to($car->driver->user->email)->
        queue(new CarListed($car));

        return redirect('/cars');
    }

    public function show($car)
    {
        $car = Car::find($car); // Fetch car by ID
        if (!$car) {
            return view('error');
        }
        return view('car', ['car' => $car]);
    }






    public function edit(Car $car)
    {
        if(Auth::guest()){
            return redirect('/login');
        }
        if( Auth::user()->id != $car->driver->user_id){
            return redirect('/cars');
        }

        if (!$car) {
            return view('error');
        }
        return view('edit', ['car' => $car]);
    }





    public function update($car)
    {
        request()->validate([
            'name' => 'required',
            'model' => 'required'
        ]);

        $car = Car::findOrFail($car); // Fetch car by ID
        if (!$car) {
            return view('error');
        }

        $car->update([
            'name' => request('name'),
            'model' => request('model')
        ]);

        return redirect('/cars/' . $car->id);
    }

    public function destroy($car)
    {
        $car = Car::findOrFail($car); // Fetch car by ID

        $car->delete();
        return redirect('/cars');
    }

}


