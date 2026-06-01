<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'street_name', 'lat', 'lng', 'type', 'height',
        'size', 'description', 'status', 'user_id',
    ];

    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}
