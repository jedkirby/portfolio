<?php

namespace App\Domain\Interest\Command\Validator;

use App\Domain\Interest\Command\InterestCommand;
use Illuminate\Validation\Factory as Validator;

class InterestValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param InterestCommand $command
     *
     * @return array
     */
    public function validate(InterestCommand $command)
    {
        $errors = [];

        $validator = $this->validator->make(
            (array) $command,
            [
                'email' => 'required|email',
            ]
        );

        if ($validationErrors = $validator->errors()) {
            foreach ($validationErrors->toArray() as $field => $error) {
                $errors[$field] = reset($error);
            }
        }

        return $errors;
    }
}
