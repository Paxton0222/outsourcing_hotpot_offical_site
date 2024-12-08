<?php

namespace App\Services;

use App\Data\PermissionGroupData;
use App\Services\CrudByIdService;
use App\Services\CrudByIdServiceInterface;
use App\Repositories\RoleRepository;

class RoleService implements CrudByIdServiceInterface
{
    use CrudByIdService;

    private RoleRepository $RoleRepository;

    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
        $this->initRepository($this->RoleRepository);
    }
}
