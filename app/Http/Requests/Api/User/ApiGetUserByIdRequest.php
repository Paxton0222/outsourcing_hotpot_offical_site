<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Interfaces\CrudGetRequestInterface;
use App\Http\Requests\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class ApiGetUserByIdRequest extends FormRequest implements CrudGetRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
