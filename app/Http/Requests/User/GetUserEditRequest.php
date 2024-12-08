<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Traits\Page;
use Illuminate\Foundation\Http\FormRequest;

class GetUserEditRequest extends FormRequest
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
