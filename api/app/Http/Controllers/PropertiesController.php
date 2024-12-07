<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Feature;
use App\Models\PropertyFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Exception;
use Illuminate\Log\Logger;

class PropertiesController extends Controller
{
    public function index()
    {
        return Property::all();
    }

    public function store2(Request $request){
        return response()->json(['message' => 'Testing'], 201);
    }

    public function store(Request $request)
    {
        //$logger = new Logger();
        try{
            // Validar los datos entrantes
            $this->validate($request, [
                'description' => 'required|string|max:250',
                'address' => 'required|string|max:250',
                'district_id' => 'required|integer|exists:districts,id',
                'base_price' => 'required|numeric',
                'covered_area' => 'required|numeric',
                'build_area' => 'required|numeric',
                'total_area' => 'required|numeric',
                'rooms' => 'required|integer',
                'bathrooms' => 'required|integer',
                'year_build' => 'required|integer',
                'features' => 'array', // Lista de features
            ]);

            // Crear la propiedad
            $property = new Property();
            $property->description = $request->input('description');
            $property->address = $request->input('address');
            $property->district_id = $request->input('district_id');
            $property->base_price = $request->input('base_price');
            $property->covered_area = $request->input('covered_area');
            $property->build_area = $request->input('build_area');
            $property->total_area = $request->input('total_area');
            $property->rooms = $request->input('rooms');
            $property->bathrooms = $request->input('bathrooms');
            $property->year_build = $request->input('year_build');
            $property->created_by = 1; // Aquí puedes asignar el ID del usuario autenticado
            $property->save();

            // Crear las características (features) de la propiedad
            $features = $request->input('features', []);

            foreach ($features as $feature) {
                // Si la feature no existe, la creamos
                $existingFeature = Feature::where('feature_name', $feature)->first();

                if (!$existingFeature) {
                    $newFeature = new Feature();
                    $newFeature->feature_name = $feature;
                    $newFeature->created_by = 1; // Asigna el ID de usuario autenticado
                    $newFeature->save();
                    $featureId = $newFeature->id;
                } else {
                    $featureId = $existingFeature->id;
                }

                // Asociar la propiedad con la característica
                $propertyFeature = new PropertyFeature();
                $propertyFeature->property_id = $property->id;
                $propertyFeature->feature_id = $featureId;
                $propertyFeature->created_by = 1; // Asigna el ID de usuario autenticado
                $propertyFeature->save();
            }

            return response()->json(['message' => 'Property created successfully', 'property' => $property], 200);

        }catch(Exception $e){
            echo $e;
        }
    }

    public function show($id)
    {
        return Property::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    public function destroy($id)
    {
        Property::destroy($id);
        return response()->json(null, 204);
    }

    public function upload($id)
    {
        if(Input::hasFile('file')){
            $file = Input::file('file');

            $folder = storage_path('uploads');
            $filename = $file->getClientOriginalName();

            $date_append = date("Y-m-d-His-");
            $upload_success = Input::file('file')->move($folder, $date_append.$filename);

            if( $upload_success ) {
                return response()->json([
                    "status" => "success",
                ], 200);
            }


        }

    }
}

