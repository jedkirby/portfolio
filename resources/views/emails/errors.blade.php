<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>{{ count($errors) }} errors have been detected on the live site for the date: <strong>{{ $date->format('F j, Y') }}</strong></p>
        <ul>
            @foreach($errors as $error)
                <li>{{ array_get($error, 'message') }}</li>
            @endforeach
        </ul>
    </body>
</html>
