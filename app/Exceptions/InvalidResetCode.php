<?php

namespace App\Exceptions;

use Exception;

class InvalidResetCode extends Exception
{
    protected $errors;
    /**
     *
     * @param array $errors
     * @param string $message
     * @param int $code
     * @return void
     */
    public function __construct($errors = null, $message = null, $code = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
