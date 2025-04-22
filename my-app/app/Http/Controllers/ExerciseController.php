<?php

namespace App\Http\Controllers;
use App\Models\Exercise;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('name');  // Get the 'name' query parameter
        $exercises = Exercise::where('name', 'LIKE', "%$query%")->get();
        return response()->json($exercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exercise = Exercise::create($request->only(['name', 'description', 'answer']));
        return response()->json($exercise, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exercise = Exercise::find($id);
        if ($exercise) {
            return response()->json($exercise);
        } else {
            return response()->json(['message' => 'Exercise not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->update($request->only(['id', 'name', 'description', 'answer']));
        return response()->json(['message' => 'Updated']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exercise = Exercise::find($id);
        if ($exercise) {
            $exercise->delete();
            return response()->json(['message' => 'Exercise deleted']);
        } else {
            return response()->json(['message' => 'Exercise not found'], 404);
        }
    }


    public function showExerciseCategories($exerciseId)
    {
        $exercise = Exercise::find($exerciseId);
        $categories = $exercise->categories;  // Get all categories related to this exercise
        return response()->json($categories);  // Return categories as a JSON response
    }

}
