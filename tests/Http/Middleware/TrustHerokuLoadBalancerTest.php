<?php

namespace App\Tests\Http\Middleware;

use App\Http\Middleware\TrustHerokuLoadBalancer;
use App\Tests\AbstractTestCase as TestCase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Mockery;

/**
 * @group http
 * @group http.middleware
 */
class TrustHerokuLoadBalancerTest extends TestCase
{
    private $app;
    private $request;
    private $middleware;

    public function setUp()
    {
        $this->app = Mockery::mock(Application::class);
        $this->request = Mockery::mock(Request::class);
        $this->middleware = new TrustHerokuLoadBalancer(
            $this->app
        );
    }

    public function testSetsTrustedProxies()
    {
        $ip = '127.0.0.1';

        $this->app
            ->shouldReceive('environment')
            ->andReturn(true)
            ->once();

        $this->request
            ->shouldReceive('getClientIp')
            ->andReturn($ip)
            ->once();

        $this->request
            ->shouldReceive('setTrustedHeaderName')
            ->with(Request::HEADER_FORWARDED, null)
            ->once();

        $this->request
            ->shouldReceive('setTrustedHeaderName')
            ->with(Request::HEADER_CLIENT_HOST, null)
            ->once();

        $this->request
            ->shouldReceive('setTrustedProxies')
            ->with([$ip])
            ->once();

        $this->middleware->handle(
            $this->request,
            function () {}
        );
    }
}
