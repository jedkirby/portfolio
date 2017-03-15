<?php

namespace App\Tests\Domain\Common\Validation\Exception;

use App\Domain\Common\Validation\Exception\ValidationException;
use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group domain
 * @group domain.common
 * @group domain.common.validation
 * @group domain.common.validation.exception
 */
class ValidationExceptionTest extends TestCase
{
    public function testCanCreateWithErrors()
    {
        $errors = [
            'name' => 'Required',
        ];

        $e = ValidationException::withErrors($errors);

        $this->assertEquals(
            $e->getErrors(),
            $errors
        );
    }

    public function testCanSetErrorsAfterCreatingException()
    {
        $errors = [
            'email' => 'Valid email required',
        ];

        $e = new ValidationException();
        $e->setErrors($errors);

        $this->assertEquals(
            $e->getErrors(),
            $errors
        );
    }
}
