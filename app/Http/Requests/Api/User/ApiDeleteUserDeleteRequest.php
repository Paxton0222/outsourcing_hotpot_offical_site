<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Interfaces\CrudDeleteRequestInterface;
use App\Http\Requests\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class ApiDeleteUserDeleteRequest extends FormRequest implements CrudDeleteRequestInterface
{
    use ApiResponse;
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
