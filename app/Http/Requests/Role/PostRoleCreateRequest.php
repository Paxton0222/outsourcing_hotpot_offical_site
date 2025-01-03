<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\Traits\ResponseMessage;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PostRoleCreateRequest extends FormRequest
{
    use ResponseMessage;

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
