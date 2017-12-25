<?php

namespace App\Http\Controllers\Api;

use App\Domain\Storage\StorageManager;
use App\Domain\Service\Ping\PingFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PingController extends BaseController
{
    /**
     * @var StorageManager
     */
    private $storageManager;

    /**
     * @param StorageManager $storageManager
     */
    public function __construct(
        StorageManager $storageManager
    ) {
        $this->storageManager = $storageManager->setId('api.ping');
    }

    /**
     * @param Request $request
     */
    public function __invoke(
        Request $request
    ) {
        $entity = PingFactory::create(
            $request->get('service'),
            $request
        );

        $entities = array_merge(
            $this->storageManager->getItems(),
            [
                $entity,
            ]
        );

        $this->storageManager->setItems($entities);
    }
}

