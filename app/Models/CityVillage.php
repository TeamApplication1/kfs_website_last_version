<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityVillage extends Model
{
    use HasFactory;

    protected $fillable = ['center_id', 'name', 'type', 'is_active', 'sort_order'];

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
