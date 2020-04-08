@extends('master')

@section('id', 'policy')
@section('content')

    <div class="cookie">

        <div class="site__full">
            <div class="col--wrapper">


                <h2>{{ $title }}</h2>
                <p>
                    We do use cookies to store information, such as your personal preferences when you visit our site. This could include only showing you a popup once in your visit, or the ability to login to some of our features, such as forums or comments.
                </p>

                <p>
                    We also use third party advertisements on <a href="https://jedkirby.com">jedkirby.com</a> to support our site. Some of these advertisers may use technology such as cookies and web beacons when they advertise on our site, which will also send these advertisers (such as Google through the Google Adsense program) information including your IP address, your ISP, the browser you used to visit our site, and in some cases, whether you have Flash installed. This is generally used for geotargeting purposes (showing New York real estate ads to someone in New York, for example) or showing certian ads based on specific sites visited (such as showing cooking ads to someone who frequents cooking sites).
                </p>

                <h3>Our Cookies</h3>
                <p>
                    The below table lists all known cookies that are used on the website to provide functionality:
                </p>

                <?php

                    $cookies = [
                        [
                            'name' => '__cfduid',
                            'provider' => 'Cloudflare',
                            'purpose' => 'Identifying individual visitors privately.',
                            'expiry' => '1 Month',
                            'type' => 'HTTP Cookie',
                        ],
                        [
                            'name' => '_ga',
                            'provider' => 'Google',
                            'purpose' => 'Registers a unique ID that is used to generate statistical data on how the visitor uses the website.',
                            'expiry' => '2 Years',
                            'type' => 'HTTP Cookie',
                        ],
                        [
                            'name' => '_gid',
                            'provider' => 'Google',
                            'purpose' => 'Registers a unique ID that is used to generate statistical data on how the visitor uses the website.',
                            'expiry' => '24 Hours',
                            'type' => 'HTTP Cookie',
                        ],
                        [
                            'name' => 'session',
                            'provider' => 'James Kirby',
                            'purpose' => 'Preserves user session state across page requests.',
                            'expiry' => 'Session',
                            'type' => 'HTTP Cookie',
                        ],
                        [
                            'name' => 'XSRF-TOKEN',
                            'provider' => 'James Kirby',
                            'purpose' => 'Token used to verify that the authenticated user is the one actually making the requests to the application.',
                            'expiry' => 'Session',
                            'type' => 'HTTP Cookie',
                        ],
                    ];

                ?>

                <div class="cookie__container">
                    <div class="cookie__inner">
                        
                        <table>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Provider</td>
                                    <td width="55%">Purpose</td>
                                    <td>Expiry</td>
                                    <td>Type</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cookies as $cookie)

                                    <tr>
                                        <td>{{ array_get($cookie, 'name') }}</td>
                                        <td>{{ array_get($cookie, 'provider') }}</td>
                                        <td>{{ array_get($cookie, 'purpose') }}</td>
                                        <td>{{ array_get($cookie, 'expiry') }}</td>
                                        <td>{{ array_get($cookie, 'type') }}</td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

                <h3>Disabling Cookies</h3>
                <p>
                    You can chose to disable or selectivley turn off our cookies or third-party cookies in your browsers settings, or by managing preferences in programs such as Norton Internet Security. However, this can affect how you are able to interact with our site as well as other websites. This could include the inability to login to services or programs, such  as logging into forums or accounts.
                </p>

                <p>
                    An alternative method is to opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" rel="nofollow">Ads Settings</a>. or opt out of a third-party vendor's use of cookies for personalized advertising by visiting <a href="https://www.aboutads.info" rel="nofollow">aboutads.info</a>.
                </p>

            </div>
        </div>

    </div>

@stop
