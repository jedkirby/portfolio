<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>
			This message has been auto-generated by the server at <strong>{{ $site }}</strong>. 
			It displays important information that has derived from the 
			contact form.
		</p>
		<p>
			<strong>Name: </strong> {{ $name }}<br />
			<strong>Email: </strong> {{ $email }}<br />
			<strong>Subject: </strong> {{ $subject }}<br />
			<strong>IP: </strong> {{ $ip }}<br />
			<strong>Sent: </strong> {{ $sent }}
		</p>
		<p>{{ $content }}</p>
	</body>
</html>
