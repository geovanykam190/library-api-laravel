<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $statusCode;

    public function construct($message = 'Erro personalizado padrão', $statusCode = 400)
    {
        parent::construct($message);

        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->statusCode);
    }
}
