<?php

namespace App\Domain\Contact\Command;

use DateTime;
use Illuminate\Http\Request;

class ContactCommand
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $message;

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
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     * @param string $ip
     * @param string $honeypot
     */
    public function __construct(
        $name,
        $email,
        $subject,
        $message,
        $ip,
        $honeypot
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->ip = $ip;
        $this->honeypot = $honeypot;
        $this->datetime = new DateTime();
    }

    /**
     * @param Request $request
     *
     * @return ContactRequestCommand
     */
    public static function fromRequest(Request $request)
    {
        return new static(
            $request->get('name'),
            $request->get('email'),
            $request->get('subject'),
            $request->get('message'),
            $request->getClientIp(),
            $request->get('honeypot', '')
        );
    }

    /**
     * @return ContactRequestCommand
     */
    public static function make()
    {
        return new static('', '', '', '', '', '');
    }
}
