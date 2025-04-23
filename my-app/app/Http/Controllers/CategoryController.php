<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Fetch all categories
    public function index()
    {
        $categories = Category::all(); // You can paginate if needed
        return response()->json($categories);
    }

    // Fetch a single category by its ID
    public function show($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    // Store a new category
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7', // Assuming color is in hex format like '#FFFFFF'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new category
        $category = Category::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json($category, 201); // 201 Created
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->only(['name', 'color']));
        return response()->json(['message' => 'Updated']);
    }


    // Delete a category
    public function destroy($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Delete the category
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
