<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $startTime = Carbon::now()->addDays(rand(1, 10))->setHour(10)->setMinute(0);

        return [
            'client_id' => User::factory(),
            'provider_id' => User::factory(),
            'service_id' => Service::factory(),
            'start_time' => $startTime,
            'end_time' => (clone $startTime)->addMinutes(60),
            'status' => 'confirmed',
            'notes' => fake()->sentence(),
        ];
    }
}
