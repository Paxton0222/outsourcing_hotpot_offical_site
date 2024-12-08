<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Permission\ApiDeletePermissionDeleteRequest;
use App\Http\Requests\Api\Permission\ApiGetPermissionByIdRequest;
use App\Http\Requests\Api\Permission\ApiGetPermissionPageRequest;
use App\Http\Requests\Api\Permission\ApiPostPermissionCreateRequest;
use App\Http\Requests\Api\Permission\ApiPutPermissionUpdateRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionApiController extends Controller
{
    use CrudByIdApiController {
        CrudByIdApiController::get as private getById;
        CrudByIdApiController::getPage as private getAllByPage;
    }

    private PermissionService $service;

    public function __construct(PermissionService $PermissionService)
    {
        $this->service = $PermissionService;
        $this->initService($this->service);
    }

    public function get(ApiGetPermissionByIdRequest $request): JsonResponse
    {
        return $this->getById($request);
    }

    public function getPage(ApiGetPermissionPageRequest $request): JsonResponse
    {
        return $this->getAllByPage($request, 'Permission 分頁');
    }
}
