<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        return Favorite::all();
    }

    public function store(Request $request)
    {
        $favorite = Favorite::create($request->all());
        return response()->json($favorite, 201);
    }

    public function show($id)
    {
        return Favorite::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->update($request->all());
        return response()->json($favorite, 200);
    }

    public function destroy($id)
    {
        Favorite::destroy($id);
        return response()->json(null, 204);
    }
}
