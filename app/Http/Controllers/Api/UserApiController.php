<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ApiDeleteUserDeleteRequest;
use App\Http\Requests\Api\User\ApiGetUserByIdRequest;
use App\Http\Requests\Api\User\ApiGetUserPageRequest;
use App\Http\Requests\Api\User\ApiPostUserCreateRequest;
use App\Http\Requests\Api\User\ApiPutUserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    use CrudByIdApiController {
        CrudByIdApiController::get as private getById;
        CrudByIdApiController::getPage as private getAllByPage;
        CrudByIdApiController::create as private createOne;
        CrudByIdApiController::update as private updateById;
        CrudByIdApiController::delete as private deleteById;
    }

    private UserService $service;

    public function __construct(UserService $UserService)
    {
        $this->service = $UserService;
        $this->initService($this->service);
    }

    public function get(ApiGetUserByIdRequest $request): JsonResponse
    {
        return $this->getById($request);
    }

    public function getPage(ApiGetUserPageRequest $request): JsonResponse
    {
        return $this->getAllByPage($request, 'User 分頁');
    }

    public function create(ApiPostUserCreateRequest $request): JsonResponse
    {
        return $this->createOne($request);
    }

    public function update(ApiPutUserUpdateRequest $request): JsonResponse
    {
        return $this->updateById($request);
    }

    public function delete(ApiDeleteUserDeleteRequest $request): JsonResponse
    {
        return $this->deleteById($request);
    }
}
