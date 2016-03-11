<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\ContactRequest;

class ContactController extends RootController {

	protected $complete = false;

	public function getForm($section = null)
	{

		$this->setTitle('Contact');
		$this->setDescription('If you have a specific requirement that you\'d like to talk about, simply fill in this form as fully as possible and I will personally get back to you. Having worked with clients in a number of different time zones, I\'ve given up on using the phone. However, you can reach me through e-mail.');

		return view('pages.contact', [
			'complete' => $this->complete,
			'subject'  => $this->fetchSubject($section)
		]);

	}

	public function postForm(ContactRequest $request)
	{
		try {
			$this->sendEmail(
				\Input::get('name'),
				\Input::get('email'),
				(\Input::get('subject') ?: 'N/A'),
				\Input::get('content'),
				\Input::get('title') // Using the "title" field as a honepot for bots >:}
			);
		} catch(\Exception $e) {
			\Log::error($e);
		}

		$this->complete = true;
		return $this->getForm();

	}

	protected function sendEmail($name, $email, $subject, $content, $honeypot)
	{

		$site = \Request::server('HTTP_HOST');
		$sent = Carbon::now()->toDayDateTimeString();
		$ip   = \Request::getClientIp();

		$emailSubject = 'Contact';
		if (!empty($honeypot)) {
			$emailSubject .= ' - Bot';
		}

		\Mail::send(
			'emails.contact',
			compact('name', 'email', 'subject', 'content', 'site', 'sent', 'ip'),
			function($message) use ($emailSubject) {
				$message->from(\Config::get('site.meta.email.from'), 'Portfolio');
				$message->to(\Config::get('site.meta.email.to'), \Config::get('site.meta.title'));
				$message->subject($emailSubject);
			}
		);

	}

	protected function fetchSubject($section)
	{
		switch($section){
			case 'demo':
				return 'Demo Request';
			case 'more':
				return 'Request More Information';
			case 'cv':
				return 'CV Request';
			case 'interested':
				return 'Interested In Services';
			default:
				return '';
		}
	}

}
