<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'parent_id',
        'name',
        'key',
    ];

    public function subPermission(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
}
