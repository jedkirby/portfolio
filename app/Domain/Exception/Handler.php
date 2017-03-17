<?php

namespace App\Domain\Exception;

use App\Domain\Domain;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler
{
    /**
     * @var Domain
     */
    private $domain;

    /**
     * @param Domain $domain
     */
    public function __construct(
        Domain $domain
    ) {
        $this->domain = $domain;
    }

    /**
     * Render the given HttpException.
     *
     * @param \Symfony\Component\HttpKernel\Exception\HttpException $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        switch ($status) {
            case 404:
                $this->domain->setTitle('Page Not Found');
                break;
            default:
                $this->domain->setTitle(sprintf('%s Error', $status));
        }

        return view(
            'errors.generic',
            [
                'title' => $this->domain->getTitle(),
                'description' => $this->domain->getDescription(),
                'keywords' => $this->domain->getKeywords(),
                'author' => $this->domain->getAuthor(),
                'status' => $status,
                'id' => implode(
                    '  ',
                    [
                        'error',
                        'error__generic',
                    ]
                ),
            ]
        );
    }
}
