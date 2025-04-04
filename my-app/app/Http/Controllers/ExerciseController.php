<?php

namespace App\Http\Controllers;
use App\Models\Exercise;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Exercise::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $exercise = Exercise::find($id); // Fetch car by ID
        if (!$exercise) {
            return response()->json([
                'name' => 'Not found',
                'description' => 'Exercise with such id does not exist'
            ]);
        }
        return response()->json($exercise);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
