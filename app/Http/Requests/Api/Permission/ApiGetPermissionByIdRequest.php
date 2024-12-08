<?php

namespace App\Http\Requests\Api\Permission;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudGetRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ApiGetPermissionByIdRequest extends FormRequest implements CrudGetRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:permissions,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
