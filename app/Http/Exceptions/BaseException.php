<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BaseException extends Exception
{
    protected array $details;

    public function __construct($message = '', string $channel = 'daily', $code = 0, ?Exception $previous = null, $details = [])
    {
        parent::__construct($message, $code, $previous);
        $this->details = $details;
        Log::channel($channel)->error($message, [
            'line' => $this->line,
            'code' => $code,
            'previous' => $previous,
            'details' => $details,
        ]);
    }

    public function getDetails()
    {
        return $this->details;
    }
}
