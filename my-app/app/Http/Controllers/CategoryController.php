<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\password;

class CategoryController extends Controller
{

    public function index()
{
    return response()->json(Category::all());
}



}
