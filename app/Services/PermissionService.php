<?php

namespace App\Services;

use App\Data\PermissionGroupData;
use App\Services\CrudByIdService;
use App\Services\CrudByIdServiceInterface;
use App\Repositories\PermissionRepository;

class PermissionService implements CrudByIdServiceInterface
{
    use CrudByIdService;

    private PermissionRepository $PermissionRepository;

    public function __construct(PermissionRepository $PermissionRepository)
    {
        $this->PermissionRepository = $PermissionRepository;
        $this->initRepository($this->PermissionRepository);
    }
    public function permission_groups(): array
    {
        $result = [];
        $permissions = $this->all();
        foreach ($permissions as $permission) {
            $parent_id = $permission->parent_id;
            if ($parent_id === 0){
                $result[$permission->id] = new PermissionGroupData($permission);
            }
        }
        foreach ($permissions as $permission) {
            $parent_id = $permission->parent_id;
            if ($parent_id !== 0)
            {
                $permissionGroup = $result[$permission->parent_id];
                $permissionGroup->permissions[] = $permission;
            }
        }
        $array_result = [];
        collect($result)->each(function (PermissionGroupData $permission) use (&$array_result) {
            $array_result[] = $permission;
        });
        return $array_result;
    }
}
