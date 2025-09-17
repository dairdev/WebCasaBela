<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Province;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
        return Department::all();
    }

    public function store(Request $request)
    {
        $department = Department::create($request->all());
        return response()->json($department, 201);
    }

    public function show($id)
    {
        return Department::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return response()->json($department, 200);
    }

    public function destroy($id)
    {
        Department::destroy($id);
        return response()->json(null, 204);
    }

    // Método para obtener todas las provincias de un departamento
    public function getProvincesByDepartment($department_id)
    {
        try {
            // Obtenemos las provincias filtradas por el id del departamento
            $provinces = Province::where('department_id', $department_id)->get();

            // Verificamos si existen provincias para el departamento dado
            if ($provinces->isEmpty()) {
                return response()->json([
                    'message' => 'No provinces found for the given department'
                ], 404);
            }

            return response()->json($provinces, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching provinces',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

