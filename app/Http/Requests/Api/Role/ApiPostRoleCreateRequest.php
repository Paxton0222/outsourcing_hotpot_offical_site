<?php

namespace App\Http\Requests\Api\Role;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudPostRequestInterface;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiPostRoleCreateRequest extends FormRequest implements CrudPostRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Role::class, 'name'),
            ],
            'desc' => [
                'required',
                'string',
                'max:255',
            ],
            'perm_ids' => [
                'array',
            ],
            'perm_ids.*' => [
                'int',
                Rule::exists(Permission::class, 'id'),
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
