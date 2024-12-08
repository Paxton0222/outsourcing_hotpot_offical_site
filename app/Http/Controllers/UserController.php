<?php

namespace App\Http\Controllers;

use App\Exceptions\UserExistsException;
use App\Http\Controllers\Api\CrudByIdApiController;
use App\Http\Requests\User\DeleteUserDeleteRequest;
use App\Http\Requests\User\GetUserEditRequest;
use App\Http\Requests\User\PostUserCreateRequest;
use App\Http\Requests\User\PutUserUpdateRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    use CrudByIdApiController {
        CrudByIdApiController::get as private getById;
        CrudByIdApiController::create as private createOne;
        CrudByIdApiController::update as private updateById;
        CrudByIdApiController::delete as private deleteById;
    }

    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
        $this->initService($this->UserService);
    }

    public function edit(GetUserEditRequest $request): Response
    {
        [$page, $prePage, $search, $asc, $desc] = checkAndSetPageParameters($request, 1, 10);
        $pageInfo = $this->UserService->getPage(page: $page, perPage: $prePage, search: $search, asc: $asc, desc: $desc);
        $result = [
            'query' => [
                'page' => $page,
                'perPage' => $prePage,
                'search' => $search,
                'asc' => $asc,
                'desc' => $desc,
            ],
            'data' => $pageInfo->items(),
            'roles' => resolve(RoleService::class)->all(),
        ];

        return Inertia::render('UserEdit', $result);
    }

    /**
     * @throws UserExistsException
     */
    public function create(PostUserCreateRequest $request): RedirectResponse
    {
        $this->UserService->create($request->all());

        return Redirect::to(route('user.edit', $request->query()));
    }

    public function update(PutUserUpdateRequest $request): RedirectResponse
    {
        $this->updateById($request);

        return Redirect::to(route('user.edit', $request->query()));
    }

    public function delete(DeleteUserDeleteRequest $request): RedirectResponse
    {
        $this->deleteById($request);

        return Redirect::to(route('user.edit', $request->query()));
    }
}
