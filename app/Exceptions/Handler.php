<?php namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException',
		'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		return parent::render($request, $e);
	}

	/**
	 * Render the given HttpException.
	 *
	 * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function renderHttpException(HttpException $e)
	{

		$status = $e->getStatusCode();

		$unique = 'errors.'.$status;
		$generic = 'errors.generic';

		switch(true){
			case view()->exists($unique):
				$view  = $unique;
				$class = $status;
				break;
			case view()->exists($generic):
				$view  = $generic;
				$class = 'generic';
				break;
			default:
				return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
		}

		return response()->view(
			$view,
			[
				'title'       => $status,
				'description' => '',
				'keywords'    => '',
				'pageid'      => implode('  ', ['error', 'error__'.$class]),
				'facebookId'  => \Config::get('site.social.streams.facebook.id'),
				'status'      => $status
			],
			$status
		);

	}

}
