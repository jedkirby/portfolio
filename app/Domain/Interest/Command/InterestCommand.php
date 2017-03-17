<?php

namespace App\Domain\Interest\Command;

use DateTime;
use Illuminate\Http\Request;

class InterestCommand
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $honeypot;

    /**
     * @var DateTime
     */
    public $datetime;

    /**
     * @param string $email
     * @param string $ip
     * @param string $honeypot
     */
    public function __construct(
        $email,
        $ip,
        $honeypot
    ) {
        $this->email = $email;
        $this->ip = $ip;
        $this->honeypot = $honeypot;
        $this->datetime = new DateTime();
    }

    /**
     * @param Request $request
     *
     * @return InterestCommand
     */
    public static function fromRequest(Request $request)
    {
        return new static(
            $request->get('email'),
            $request->getClientIp(),
            $request->get('honeypot', '')
        );
    }
}
