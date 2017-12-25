<?php

namespace App\Domain\Service\Ping\Entity\Service;

use App\Domain\Service\Ping\Entity\Ping;
use App\Domain\Service\Ping\Entity\PingInterface;
use Illuminate\Http\Request;

class HerokuBuildpackTypekit extends Ping implements PingInterface
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return implode(
            ', ',
            [
                $this->getDomain(),
            ]
        );
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * {@inheritdoc}
     */
    public function fromRequest(Request $request)
    {
        $this->setDomain($request->get('domain'));
    }
}
