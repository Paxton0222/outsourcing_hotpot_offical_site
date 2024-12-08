<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Interfaces\CrudPutRequestInterface;
use App\Http\Requests\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiPutUserUpdateRequest extends FormRequest implements CrudPutRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->get('id')),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
