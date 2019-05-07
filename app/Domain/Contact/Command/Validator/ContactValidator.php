<?php

namespace App\Domain\Contact\Command\Validator;

use App\Domain\Contact\Command\ContactCommand;
use Illuminate\Validation\Factory as Validator;

class ContactValidator
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
     * @param ContactCommand $command
     *
     * @return array
     */
    public function validate(ContactCommand $command)
    {
        $errors = [];

        $validator = $this->validator->make(
            (array) $command,
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'recaptcha' => 'recaptcha',
            ],
            [
                'required' => 'Required',
                'email' => 'Invalid Email',
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
