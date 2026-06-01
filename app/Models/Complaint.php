<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'national_id',
        'subject', 'message', 'attachment',
        'status', 'admin_reply', 'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];
}
