<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\ApiDeleteRoleDeleteRequest;
use App\Http\Requests\Api\Role\ApiGetRoleByIdRequest;
use App\Http\Requests\Api\Role\ApiGetRolePageRequest;
use App\Http\Requests\Api\Role\ApiPostRoleCreateRequest;
use App\Http\Requests\Api\Role\ApiPutRoleUpdateRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleApiController extends Controller
{
    use CrudByIdApiController {
        CrudByIdApiController::get as private getById;
        CrudByIdApiController::getPage as private getAllByPage;
        CrudByIdApiController::create as private createOne;
        CrudByIdApiController::update as private updateById;
        CrudByIdApiController::delete as private deleteById;
    }

    private RoleService $service;

    public function __construct(RoleService $RoleService)
    {
        $this->service = $RoleService;
        $this->initService($this->service);
    }

    public function get(ApiGetRoleByIdRequest $request): JsonResponse
    {
        return $this->getById($request);
    }

    public function getPage(ApiGetRolePageRequest $request): JsonResponse
    {
        return $this->getAllByPage($request, 'Role 分頁');
    }

    public function create(ApiPostRoleCreateRequest $request): JsonResponse
    {
        return $this->createOne($request);
    }

    public function update(ApiPutRoleUpdateRequest $request): JsonResponse
    {
        return $this->updateById($request);
    }

    public function delete(ApiDeleteRoleDeleteRequest $request): JsonResponse
    {
        return $this->deleteById($request);
    }
}
