<?php

namespace App\Http\Requests\Traits;

use App\Http\Requests\Traits\Page;
use App\Http\Requests\Traits\ResponseMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    use Page, ResponseMessage;

    /**
     * 定義參數驗證失敗回傳
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['failed' => $validator->failed(), 'errors' => $validator->errors(), 'status' => false], Response::HTTP_UNPROCESSABLE_ENTITY, options: JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
    }

    /**
     * 定義權限驗證失敗回傳
     */
    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(response()->json(['status' => false], Response::HTTP_UNAUTHORIZED, options: JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
    }
}
