<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_active', 'sort_order'];

    public function cityVillages(): HasMany
    {
        return $this->hasMany(CityVillage::class);
    }
}
