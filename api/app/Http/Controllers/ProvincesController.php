<?php

namespace App\Http\Controllers;

use App\Models\District;
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
    //
// Método para obtener todas las distritos de una provincia
    public function getDistrictsByProvince($province_id)
    {
        try {
            // Obtenemos las provincias filtradas por el id del departamento
            $districts = District::where('province_id', $province_id)->get();

            // Verificamos si existen provincias para el departamento dado
            if ($districts->isEmpty()) {
                return response()->json([
                    'message' => 'No districts found for the given province'
                ], 404);
            }

            return response()->json($districts, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching provinces',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

