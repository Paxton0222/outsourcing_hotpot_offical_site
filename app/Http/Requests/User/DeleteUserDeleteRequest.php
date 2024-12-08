<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Traits\ResponseMessage;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserDeleteRequest extends FormRequest
{
    use ResponseMessage;

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
