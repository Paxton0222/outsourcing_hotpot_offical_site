<?php

namespace App\Http\Requests\Api\Permission;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudPutRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ApiPutPermissionUpdateRequest extends FormRequest implements CrudPutRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|exists:permissions,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
