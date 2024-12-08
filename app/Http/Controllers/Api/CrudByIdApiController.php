<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserExistsException;
use App\Http\Requests\Interfaces\CrudDeleteRequestInterface;
use App\Http\Requests\Interfaces\CrudGetRequestInterface;
use App\Http\Requests\Interfaces\CrudPostRequestInterface;
use App\Http\Requests\Interfaces\CrudPutRequestInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait CrudByIdApiController
{
    public function initService($service): void
    {
        $this->service = $service;
    }

    /**
     * @throws UserExistsException
     */
    public function create(CrudPostRequestInterface|Request $request): JsonResponse
    {
        $result = $this->service->create($request->toArray());

        return response()->json($result, HttpResponse::HTTP_CREATED);
    }

    public function update(CrudPutRequestInterface|Request $request): JsonResponse
    {
        $result = $this->service->update($request->get('id'), $request->except('id'));

        return response()->json($result);
    }

    public function get(CrudGetRequestInterface|Request $request): JsonResponse
    {
        $result = $this->service->get($request->get('id'));

        return response()->json($result);
    }

    public function getPage(CrudGetRequestInterface|Request $request, string $pageName = 'page'): JsonResponse
    {
        $result = $this->service->getPage(
            page: $request->get('page', 1),
            perPage: $request->get('perPage', 10),
            search: $request->get('search', []),
            asc: $request->get('asc', []),
            desc: $request->get('desc', []),
            pageName: $pageName,
        );

        return response()->json($result->toArray());
    }

    public function delete(CrudDeleteRequestInterface|Request $request): JsonResponse
    {
        $this->service->delete($request->get('id'));

        return Response::json(null, HttpResponse::HTTP_NO_CONTENT);
    }
}
