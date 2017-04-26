<?php

namespace App\Domain\Contact\Command;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Contact\Command\Validator\ContactValidator;
use App\Domain\Contact\Entity\Contact;
use App\Domain\Contact\Jobs\SendContactEmail;

class ContactHandler
{
    /**
     * @var ContactValidator
     */
    private $validator;

    /**
     * @param ContactValidator $validator
     */
    public function __construct(ContactValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ContactCommand $command
     *
     * @throws SpamException
     * @throws ValidationException
     *
     * @return Contact
     */
    public function handle(ContactCommand $command)
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            throw ValidationException::withErrors($errors);
        }

        if ($command->honeypot !== '') {
            throw new SpamException();
        }

        $entity = new Contact();
        $entity->setName($command->name);
        $entity->setEmail($command->email);
        $entity->setSubject($command->subject);
        $entity->setMessage($command->message);
        $entity->setDatetime($command->datetime);
        $entity->setIp($command->ip);

        $sendContactEmailJob = new SendContactEmail($entity);

        dispatch($sendContactEmailJob);

        return $entity;
    }
}
