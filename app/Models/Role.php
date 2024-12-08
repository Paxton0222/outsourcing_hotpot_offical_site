<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use LaravelIdea\Helper\App\Models\_IH_Permission_C;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'perm_ids',
    ];

    protected $casts = [
        'perm_ids' => 'array',
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function permission(): Collection
    {
        return Permission::whereIn('id', $this->perm_ids)->get();
    }
}
