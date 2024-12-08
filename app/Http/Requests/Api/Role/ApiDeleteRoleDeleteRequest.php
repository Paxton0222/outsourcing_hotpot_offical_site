<?php

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudDeleteRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ApiDeleteRoleDeleteRequest extends FormRequest implements CrudDeleteRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:roles,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
