<?php

namespace App\Http\Api;

use App\Http\Requests\InterestRequest;
use Carbon\Carbon;
use Config;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Log;
use Mail;
use Response;

class Interest extends BaseController
{
    public function postRegister(InterestRequest $request)
    {
        $success = false;
        $error = false;
        $site = $request->server('HTTP_HOST');
        $email = $request->input('email');
        $ip = $request->getClientIp();
        $sent = Carbon::now()->toDayDateTimeString();

        try {
            Mail::send(
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

            $success = true;
        } catch (Exception $e) {
            Log::error($e);
            $error = $e->getMessage();
        }

        return Response::json(compact('success', 'error'), 200);
    }
}
