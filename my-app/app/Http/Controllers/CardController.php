<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;


class CardController extends Controller
{

    public function index()
    {
        return response()->json(Card::all());
    }


    public function create()
    {

    }


    public function store()
    {

    }


    public function show($id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        return response()->json($card);
    }



    public function destroy($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


}
