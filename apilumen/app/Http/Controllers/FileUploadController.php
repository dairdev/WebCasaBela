<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    // Método para manejar la subida de archivos
    public function upload(Request $request)
    {
        // Validar la solicitud
        $this->validate($request, [
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Obtener el archivo de la solicitud
        $file = $request->file('file');

        // Subir el archivo al almacenamiento local (o cualquier otro disco configurado)
        $filePath = $file->store('uploads', 'public');

        // Retornar la respuesta con la ruta del archivo subido
        return response()->json([
            'message' => 'Archivo subido exitosamente',
            'file_path' => $filePath
        ]);
    }
}

