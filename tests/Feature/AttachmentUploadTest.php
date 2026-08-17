<?php

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('se puede subir un comprobante a AWS S3 para una cita', function () {
    // Simular el disco de almacenamiento S3
    Storage::fake('s3');

    $client = User::factory()->create();
    $appointment = Appointment::factory()->create([
        'client_id' => $client->id,
    ]);

    // Crear un archivo PDF ficticio
    $file = UploadedFile::fake()->create('comprobante.pdf', 500, 'application/pdf');

    $response = $this->actingAs($client)
                     ->postJson("/api/appointments/{$appointment->id}/attachment", [
                         'attachment' => $file,
                     ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['message', 'path', 'url']);

    // Assert que el archivo fue almacenado en el disco S3 falso
    Storage::disk('s3')->assertExists('attachments/' . $file->hashName());

    // Assert que el registro en la base de datos fue actualizado
    $this->assertDatabaseHas('appointments', [
        'id' => $appointment->id,
        'attachment_path' => 'attachments/' . $file->hashName(),
    ]);
});