<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvincesController extends Controller
{
    public function index()
    {
        return Province::all();
    }

    public function store(Request $request)
    {
        $province = Province::create($request->all());
        return response()->json($province, 201);
    }

    public function show($id)
    {
        return Province::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);
        $province->update($request->all());
        return response()->json($province, 200);
    }

    public function destroy($id)
    {
        Province::destroy($id);
        return response()->json(null, 204);
    }


}

