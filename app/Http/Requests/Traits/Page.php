<?php

namespace App\Http\Requests\Traits;

trait Page
{
    public function pageRules(): array
    {
        return [
            'page' => 'integer|min:1',
            'perPage' => 'integer|min:1',
            'search' => 'array',
            'asc' => 'array',
            'desc' => 'array',
        ];
    }
}
