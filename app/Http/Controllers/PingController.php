<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Storage\StorageManager;

class PingController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var StorageManager
     */
    private $storageManager;

    /**
     * @param Domain $domain
     * @param StorageManager $storageManager
     */
    public function __construct(
        Domain $domain,
        StorageManager $storageManager
    ) {
        $this->domain = $domain;
        $this->storageManager = $storageManager->setId('api.ping');
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        return view(
            'pages.pings',
            $this->getViewParams([
                'pings' => $this->storageManager->getItems(),
            ])
        );
    }
}
