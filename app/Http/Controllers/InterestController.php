<?php

namespace App\Http\Controllers;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Interest\Command\InterestCommand;
use App\Domain\Interest\Command\InterestHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class InterestController extends BaseController
{
    /**
     * @var InterestHandler
     */
    private $handler;

    /**
     * @param InterestHandler $handler
     */
    public function __construct(InterestHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request)
    {
        $command = InterestCommand::fromRequest($request);

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

        return new JsonResponse($params);
    }
}
