<?php

namespace App\Http\Requests\Interfaces;

interface CrudDeleteRequestInterface
{
    public function rules(): array;

    public function messages(): array;

    public function authorize(): bool;
}
