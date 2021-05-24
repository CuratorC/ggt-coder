<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    //
    public function render($request)
    {
        return response_error($this->getMessage());
    }
}
