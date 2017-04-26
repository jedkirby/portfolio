<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class TrustHerokuLoadBalancer
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Environments to trust the proxies on.
     *
     * @var array
     */
    private $envs = [
        'development',
        'staging',
        'production',
    ];

    /**
     * @param Application $app
     */
    public function __construct(
        Application $app
    ) {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @see https://devcenter.heroku.com/articles/getting-started-with-symfony
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
        if ($this->app->environment($this->envs)) {
            $request->setTrustedHeaderName(Request::HEADER_FORWARDED, null);
            $request->setTrustedHeaderName(Request::HEADER_CLIENT_HOST, null);
            $request->setTrustedProxies([
                $request->getClientIp(),
            ]);
        }

        return $next($request);
    }
}
