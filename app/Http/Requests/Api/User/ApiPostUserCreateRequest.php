<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Interfaces\CrudPostRequestInterface;
use App\Http\Requests\Traits\ApiResponse;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiPostUserCreateRequest extends FormRequest implements CrudPostRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'string',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|string|max:255',
            'role_id' => [
                'required',
                Rule::exists(Role::class, 'id'),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
