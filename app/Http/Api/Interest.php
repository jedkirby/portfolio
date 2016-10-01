<?php

namespace App\Http\Api;

use Log;
use Mail;
use Config;
use Response;
use Exception;
use Carbon\Carbon;
use App\Http\Requests\InterestRequest;
use Illuminate\Routing\Controller as BaseController;

class Interest extends BaseController
{

	public function postRegister(InterestRequest $request)
	{

		$success = false;
		$site    = $request->server('HTTP_HOST');
		$email   = $request->input('email');
		$ip      = $request->getClientIp();
		$sent    = Carbon::now()->toDayDateTimeString();

		try {

			$success = Mail::send(
				'emails.interest',
				compact('site', 'email', 'ip', 'sent'),
				function ($message) {
					$message
						->from(
							Config::get('site.meta.email.from'),
							'Portfolio'
						)
						->to(
							Config::get('site.meta.email.to'),
							Config::get('site.meta.title')
						)
						->subject('Interest');
				}
			);

		} catch (Exception $e) {
			Log::error($e);
		}

		return Response::json(compact('success'), 200);

	}

}
