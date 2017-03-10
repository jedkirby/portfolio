<?php

namespace App\Http\Controllers;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Contact\Command\ContactCommand;
use App\Domain\Contact\Command\ContactHandler;
use App\Domain\Domain;
use Illuminate\Http\Request;

class ContactController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var ContactHandler
     */
    private $handler;

    /**
     * @param Domain $domain
     * @param ContactHandler $handler
     */
    public function __construct(
        Domain $domain,
        ContactHandler $handler
    ) {
        $domain->setTitle('Contact');
        $domain->setDescription("If you have a specific requirement that you'd like to talk about, simply fill in this form as fully as possible and I will personally get back to you. Having worked with clients in a number of different time zones, I've given up on using the phone. However, you can reach me through e-mail.");

        $this->domain = $domain;
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return view(
            'pages.contact',
            $this->getViewParams([
                'command' => ContactCommand::make(),
                'complete' => false,
                'errors' => [],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function post(Request $request)
    {
        $command = ContactCommand::fromRequest($request);

        $params = [
            'command' => $command,
            'complete' => false,
            'errors' => [],
        ];

        try {
            if ($this->handler->handle($command)) {
                $params['complete'] = true;
            }
        } catch (ValidationException $e) {
            $params['errors'] = $e->getErrors();
        } catch (SpamException $e) {
            /*
             * Pretend we're all done here, the honeypot
             * field was filled in, and that normally
             * means it was a bot doing the filling.
             */
            $params['complete'] = true;
        }

        return view(
            'pages.contact',
            $this->getViewParams($params)
        );
    }
}
