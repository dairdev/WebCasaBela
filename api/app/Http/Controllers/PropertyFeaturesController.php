<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeature;
use Illuminate\Http\Request;

class PropertyFeaturesController extends Controller
{
    public function index()
    {
        return PropertyFeature::all();
    }

    public function store(Request $request)
    {
        $property = PropertyFeature::create($request->all());
        return response()->json($property, 201);
    }

    public function show($id)
    {
        return PropertyFeature::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $property = PropertyFeature::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    public function destroy($id)
    {
        PropertyFeature::destroy($id);
        return response()->json(null, 204);
    }
}

