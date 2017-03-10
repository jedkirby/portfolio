<?php

namespace App\Domain\Interest\Jobs;

use App\Domain\Interest\Entity\Interest;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Mail\Mailer;

class SendInterestEmail
{
    /**
     * @var Interest
     */
    private $entity;

    /**
     * @param Interest $entity
     */
    public function __construct(Interest $entity)
    {
        $this->entity = $entity;
    }

    public function handle(Mailer $mailer, Config $config)
    {
        $entity = $this->entity;

        $mailer->send(
            'emails.interest',
            [
                'address' => $entity->getEmail(),
                'ip' => $entity->getIp(),
                'date' => $entity->getDatetime()->format('F j, Y, g:i a'),
            ],
            function ($m) use ($config, $entity) {
                $m->to($config->get('site.meta.email.to'), $config->get('site.meta.author'));
                $m->from($entity->getEmail());
                $m->subject('Interest');
            }
        );
    }
}
