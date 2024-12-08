<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Traits\ResponseMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PutUserUpdateRequest extends FormRequest
{
    use ResponseMessage;

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
