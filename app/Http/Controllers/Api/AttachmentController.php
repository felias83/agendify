<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function upload(Request $request, Appointment $appointment)
    {
        $request->validate([
            'attachment' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
        ]);

        // Guardar el archivo en el disco S3 dentro de la carpeta 'attachments'
        $path = $request->file('attachment')->store('attachments', 's3');

        // Actualizar la cita con la ruta del archivo alojado en AWS S3
        $appointment->update([
            'attachment_path' => $path,
        ]);

        return response()->json([
            'message' => 'Archivo subido correctamente a AWS S3',
            'path'    => $path,
            'url'     => Storage::disk('s3')->url($path),
        ], 200);
    }
}