<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuids;

    /**
     * UUID Primary Key
     */
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * استخدم الـ UUID في الـ Route Model Binding
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
