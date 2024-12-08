<?php

namespace App\Http\Requests\Api\Permission;

use App\Http\Requests\Traits\ApiResponse;
use App\Http\Requests\Interfaces\CrudPostRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ApiPostPermissionCreateRequest extends FormRequest implements CrudPostRequestInterface
{
    use ApiResponse;

    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }
}
