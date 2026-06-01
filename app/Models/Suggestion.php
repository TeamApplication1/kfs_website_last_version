<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'subject', 'phone', 'message',
        'status', 'national_id', 'admin_reply', 'replied_at',
    ];

    protected $casts = [
        'status' => 'string',
        'replied_at' => 'datetime',
    ];
}
