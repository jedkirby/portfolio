<?php

namespace App\Domain\Common\Validation\Exception;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param array $errors
     *
     * @return ValidationException
     */
    public static function withErrors(array $errors)
    {
        $exception = new static();
        $exception->setErrors($errors);

        return $exception;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
}
