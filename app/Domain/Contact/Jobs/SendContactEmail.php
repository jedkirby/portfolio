<?php

namespace App\Domain\Contact\Jobs;

use App\Domain\Contact\Entity\Contact;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Mail\Mailer;

class SendContactEmail
{
    /**
     * @var Contact
     */
    private $entity;

    /**
     * @param Contact $entity
     */
    public function __construct(Contact $entity)
    {
        $this->entity = $entity;
    }

    public function handle(Mailer $mailer, Config $config)
    {
        $entity = $this->entity;

        $mailer->send(
            'emails.contact',
            [
                'name' => $entity->getName(),
                'address' => $entity->getEmail(),
                'ip' => $entity->getIp(),
                'content' => $entity->getMessage(),
                'date' => $entity->getDatetime()->format('F j, Y, g:i a'),
            ],
            function ($m) use ($config, $entity) {
                $m->to($config->get('site.meta.email.to'), $config->get('site.meta.author'));
                $m->from($entity->getEmail(), $entity->getName());
                $m->subject($entity->getSubject());
            }
        );
    }
}
