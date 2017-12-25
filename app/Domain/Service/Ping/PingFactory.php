<?php

namespace App\Domain\Service\Ping;

use App\Domain\Service\Ping\Entity\PingInterface;
use App\Domain\Service\Ping\Entity\Service\HerokuBuildpackTypekit;
use App\Domain\Service\Ping\Exception\UndefinedServiceException;
use Illuminate\Http\Request;

class PingFactory
{
    /**
     * @var array
     */
    private static $entities = [
        'heroku-buildpack-typekit' => HerokuBuildpackTypekit::class,
    ];

    /**
     * Create a new entity based on the service type.
     *
     * @param string $name
     * @param Request $request
     *
     * @return PingInterface
     */
    public static function create(
        $name,
        Request $request
    ) {
        if (!array_key_exists($name, static::$entities)) {
            throw new UndefinedServiceException(sprintf(
                'Unable to locate service with the name "%s".',
                $name
            ));
        }

        $entity = new static::$entities[$name];
        $entity->setService($name);

        if ($entity instanceof PingInterface) {
            $entity->fromRequest($request);
        }

        return $entity;
    }
}
