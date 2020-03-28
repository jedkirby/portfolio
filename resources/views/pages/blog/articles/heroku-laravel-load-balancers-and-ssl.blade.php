<p>
    Recently I've been working with Heroku for a few Laravel projects and I came across an issue with how assets were being loaded over non-ssl based urls.
</p>

<h3>Background</h3>
<p>
    Heroku's HTTP Routing routes each request through a layer of reverse proxies which are, among other things, responsible for load balancing and terminating SSL connections.
</p>

@include('pages.blog.sections.advert')

<h3>The Problem</h3>
<p>
    This means that <a href="https://github.com/symfony/http-foundation/blob/master/Request.php#L1223">deep down in Symfony core</a> (The building blocks of Laravel), the HTTP Request class checks for the HTTPS server variable when checking if the request is secure ...
</p>

<pre><code class="language-php">public function isSecure()
{

    ...

    $https = $this->server->get('HTTPS');

    ...

}</code></pre>

<p>
    ... and because the SSL connection is terminated at the load balancer, this variable is set to <strong>false</strong>.
</p>

<h3>Middleware to the Rescue</h3>
<p>
    The solution was to create a <strong>Middleware</strong> which will trust the Heroku load balancer as a proxy, and configure some additonal headers to maximise security. The exact details have been taken from the <a href="https://devcenter.heroku.com/articles/getting-started-with-symfony#trusting-the-load-balancer">Heroku Symfony example</a> within their docs and modified to work with <a href="https://laravel.com/docs/5.4/middleware">Laravel's Middleware</a>.
</p>

<p>
    Because I only wished for this middleware to be used on certian environments, i.e. staging and production, I've added the following check into the code to ensure the environment is correct before applying the settings:
</p>

<pre><code class="language-php">public function handle(Request $request, Closure $next)
{

    if (app()->environment(['staging', 'production'])) {

        // Apply Settings Here

    }

    return $next($request);

}</code></pre>

<p>
    <i>The above example has been simplified. The actual code utilises dependency injection to aid in <a href="https://github.com/jedkirby/portfolio/blob/2.0.0/tests/Http/Middleware/TrustHerokuLoadBalancerTest.php">testability</a>.</i>
</p>

<h3>Complete Solution</h3>
<p>
    Combining the above environment checking, and the specific settings required by Heroku, results in the following complete middleware:
</p>

<pre><code class="language-php">namespace App\Http\Middleware;

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
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($this->app->environment($this->envs)) {

            $request->setTrustedHeaderName(Request::HEADER_FORWARDED, null);
            $request->setTrustedHeaderName(Request::HEADER_CLIENT_HOST, null);

            $request->setTrustedProxies([
                $request->getClientIp(),
            ]);

        }

        return $next($request);

    }
}</code></pre>

<p>
    Finally, to ensure this middleware is run on each load of a page within the site, it should be added to the <strong>App\Http\Kernel</strong> class, specifically the <strong>protected $middleware</strong> array:
</p>

<pre><code class="language-php">...

class Kernel extends HttpKernel
{

    ...

    protected $middleware = [
        \App\Http\Middleware\TrustHerokuLoadBalancer::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    ...

}</code></pre>

<p>
    That should be it. Providing your <strong>APP_ENV</strong> matched one of the environments listed in the environments-to-trust array, it should function correctly.
</p>

<p>
    The actual implementation of this <a href="https://github.com/jedkirby/portfolio/blob/2.0.0/app/Http/Middleware/TrustHerokuLoadBalancer.php">can be found here</a>.
</p>
