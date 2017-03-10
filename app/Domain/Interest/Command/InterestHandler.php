<?php

namespace App\Domain\Interest\Command;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Interest\Command\Validator\InterestValidator;
use App\Domain\Interest\Entity\Interest;
use App\Domain\Interest\Jobs\SendInterestEmail;

class InterestHandler
{
    /**
     * @var InterestValidator
     */
    private $validator;

    /**
     * @param InterestValidator $validator
     */
    public function __construct(InterestValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param InterestCommand $command
     *
     * @throws SpamException
     * @throws ValidationException
     *
     * @return Interest
     */
    public function handle(InterestCommand $command)
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            throw ValidationException::withErrors($errors);
        }

        if ($command->honeypot !== '') {
            throw new SpamException();
        }

        $entity = new Interest();
        $entity->setEmail($command->email);
        $entity->setDatetime($command->datetime);
        $entity->setIp($command->ip);

        $sendInterestEmailJob = new SendInterestEmail($entity);

        dispatch($sendInterestEmailJob);

        return $entity;
    }
}
