<?php

namespace App\Exceptions;

use App\Domain\Domain;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var Domain
     */
    private $domain;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \App\Domain\Common\Validation\Exception\SpamException::class,
        \App\Domain\Common\Validation\Exception\ValidationException::class,
        \App\Domain\Service\Instagram\Exception\UnableToGetInstagramFeedPostsException::class,
        \App\Domain\Service\Twitter\Exception\UnableToGetLatestTweetException::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Container $container,
        Domain $domain
    ) {
        $this->container = $container;
        $this->domain = $domain;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        $unique = 'errors.' . $status;
        $generic = 'errors.generic';

        switch (true) {
            case view()->exists($unique):
                $view = $unique;
                $class = $status;
                break;
            case view()->exists($generic):
                $view = $generic;
                $class = 'generic';
                break;
            default:
                return $this->convertExceptionToResponse($e);
        }

        return response()->view(
            $view,
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
                        'error__' . $class,
                    ]
                ),
            ],
            $status,
            $e->getHeaders()
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
