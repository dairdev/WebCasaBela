<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
    public function index()
    {
        return District::all();
    }

    public function store(Request $request)
    {
        $district = District::create($request->all());
        return response()->json($district, 201);
    }

    public function show($id)
    {
        return District::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);
        $district->update($request->all());
        return response()->json($district, 200);
    }

    public function destroy($id)
    {
        District::destroy($id);
        return response()->json(null, 204);
    }
}

