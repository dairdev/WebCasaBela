<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index()
    {
        return Feature::all();
    }

    public function store(Request $request)
    {
        $feature = Feature::create($request->all());
        return response()->json($feature, 201);
    }

    public function show($id)
    {
        return Feature::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update($request->all());
        return response()->json($feature, 200);
    }

    public function destroy($id)
    {
        Feature::destroy($id);
        return response()->json(null, 204);
    }
}

