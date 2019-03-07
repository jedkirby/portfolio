<?php

namespace App\Http\Middleware;

use App\Domain\Cloudflare\Service\Cloudflare;
use App\Domain\Heroku\Service\Heroku;
use Closure;
use Illuminate\Http\Request;

/**
 * @codeCoverageIgnore
 */
class TrustProxies
{
    /**
     * @var Cloudflare
     */
    private $cloudflare;

    /**
     * @var Heroku
     */
    private $heroku;

    /**
     * @param Cloudflare $cloudflare
     * @param Heroku $heroku
     */
    public function __construct(
        Cloudflare $cloudflare,
        Heroku $heroku
    ) {
        $this->cloudflare = $cloudflare;
        $this->heroku = $heroku;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle(
        Request $request,
        Closure $next
    ) {
        $request->setTrustedHeaderName(Request::HEADER_FORWARDED, null);
        $request->setTrustedHeaderName(Request::HEADER_CLIENT_HOST, null);
        $request->setTrustedProxies(
            array_merge(
                $this->cloudflare->getProxyIps(),
                $this->heroku->getProxyIps($request)
            )
        );

        return $next($request);
    }
}
