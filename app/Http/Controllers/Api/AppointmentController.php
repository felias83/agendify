<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => ['required', 'exists:users,id'],
            'service_id'  => ['required', 'exists:services,id'],
            'start_time'  => ['required', 'date'],
        ]);

        $service = Service::findOrFail($request->service_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = (clone $startTime)->addMinutes($service->duration_minutes);

        // Verificación de solapamiento de citas
        $hasOverlap = Appointment::where('provider_id', $request->provider_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                      });
            })->exists();

        if ($hasOverlap) {
            return response()->json([
                'errors' => ['start_time' => ['El horario seleccionado ya está ocupado.']]
            ], 422);
        }

        $appointment = Appointment::create([
            'client_id'   => auth()->id(),
            'provider_id' => $request->provider_id,
            'service_id'  => $request->service_id,
            'start_time'  => $startTime,
            'end_time'    => $endTime,
            'status'      => 'confirmed',
        ]);

        return response()->json($appointment, 201);
    }
}