<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImagesController extends Controller
{
    public function index()
    {
        return PropertyImage::all();
    }

    public function store(Request $request)
    {
        $property = PropertyImage::create($request->all());
        return response()->json($property, 201);
    }

    public function show($id)
    {
        return PropertyImage::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $property = PropertyImage::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    public function destroy($id)
    {
        PropertyImage::destroy($id);
        return response()->json(null, 204);
    }
}

