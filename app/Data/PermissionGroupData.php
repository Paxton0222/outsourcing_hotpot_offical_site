<?php

namespace App\Data;

use App\Models\Permission;
use Spatie\LaravelData\Data;

class PermissionGroupData extends Data
{
    public function __construct(
        public Permission $group,
        /** @var Permission[] */
        public array $permissions = [],
    ) {}
}
