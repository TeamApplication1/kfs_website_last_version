<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_name', 'reporter_national_id', 'reporter_phone',
        'report_type', 'location_type', 'center', 'area',
        'location_description', 'latitude', 'longitude',
        'details', 'attachments', 'status',
        'admin_reply', 'replied_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'replied_at' => 'datetime',
    ];
}
