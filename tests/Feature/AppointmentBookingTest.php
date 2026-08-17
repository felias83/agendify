<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;

test('un proveedor no puede tener dos citas que se solapen en el mismo horario', function () {
    $provider = User::factory()->create();
    $client1  = User::factory()->create();
    $client2  = User::factory()->create();

    $service = Service::factory()->create([
        'provider_id' => $provider->id,
        'duration_minutes' => 60,
    ]);

    $startTime = Carbon::now()->addDay()->setHour(10)->setMinute(0);
    $endTime   = (clone $startTime)->addMinutes(60);

    // Primera cita exitosa
    Appointment::create([
        'client_id'   => $client1->id,
        'provider_id' => $provider->id,
        'service_id'  => $service->id,
        'start_time'  => $startTime,
        'end_time'    => $endTime,
        'status'      => 'confirmed',
    ]);

    // Intentar agendar en el mismo rango de tiempo
    $response = $this->actingAs($client2)->postJson('/api/appointments', [
        'provider_id' => $provider->id,
        'service_id'  => $service->id,
        'start_time'  => $startTime->toDateTimeString(),
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['start_time']);
});