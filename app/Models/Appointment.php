<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'provider_id',
        'service_id',
        'start_time',
        'end_time',
        'status',
        'attachment_path',
        'notes',
    ];
}