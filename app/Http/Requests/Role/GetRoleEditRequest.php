<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\Traits\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetRoleEditRequest extends FormRequest
{
    use Page;

    public function rules(): array
    {
        return $this->pageRules();
    }

    public function authorize(): bool
    {
        return true;
    }
}
