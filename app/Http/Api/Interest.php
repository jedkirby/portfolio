<?php namespace App\Http\Api;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\InterestRequest;
use Carbon\Carbon;

class Interest extends BaseController {

	public function postRegister(InterestRequest $request)
	{

		$success = false;
		$site    = \Request::server('HTTP_HOST');
		$email   = \Input::get('email');
		$sent    = Carbon::now()->toDayDateTimeString();
		$ip      = \Request::getClientIp();

		try {

			$success = \Mail::send(
				'emails.interest',
				compact('site', 'email', 'sent', 'ip'),
				function($message) use ($email) {
					$message->from(\Config::get('site.meta.email.from'), 'Portfolio');
					$message->to(\Config::get('site.meta.email.to'), \Config::get('site.meta.title'));
					$message->subject('Interest');
				}
			);

		} catch(\Exception $e) {
			\Log::error($e);
		}

		return \Response::json(compact('success'), 200);

	}

}
