<?php

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudPutRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ApiPutRoleUpdateRequest extends FormRequest implements CrudPutRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|exists:roles,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
