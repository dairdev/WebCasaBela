<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypesController extends Controller
{
    public function index()
    {
        return PropertyType::all();
    }

    public function store(Request $request)
    {
        $property = PropertyType::create($request->all());
        return response()->json($property, 201);
    }

    public function show($id)
    {
        return PropertyType::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $property = PropertyType::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    public function destroy($id)
    {
        PropertyType::destroy($id);
        return response()->json(null, 204);
    }
}

