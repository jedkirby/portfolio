<p>
    When my girlfriend and I purchased our <a href="https://www.instagram.com/p/B28jBVwnqk_">first house</a> together, we decided to go with British Gas' <a href="https://www.hivehome.com">Hive Home</a> products to help us with some level of automation. There are many similar alternatives out there, but Hive suited us the best so we went ahead and purchased an <a href="https://www.hivehome.com/products/hive-view-outdoor">Outdoor Camera</a> to cover the drive, an <a href="https://www.hivehome.com/products/hive-view">Indoor Camera</a> to keep an eye on our <a href="https://www.instagram.com/p/Bmg078xBZ8_/">puppy</a>, and a few <a href="https://www.hivehome.com/products/hive-active-plug">Smart Plugs</a> to automate switching lights on.
</p>

@include('pages.blog.articles.includes.advert')

<p>
    One thing I presumed they had was a Public Facing Rest API, however, I was bitterly disappointed to find that one didn't exist, and customers have been asking on their <a href="https://community.hivehome.com/s/question/0D50J00004z1HKO/hi-does-hive-have-any-external-apis-for-integration-if-so-how-do-i-get-hold-of-the-documentation-regarding-these-thanks">forums for a while now</a>, with no developments to date. This lead me down a bit of a rabbit hole, and is the basis of this post. Here's how I went about unearthing how to connect programmatically.
</p>

<h3>Capturing</h3>
<p>
    I knew that Hive has an iPhone app, which allows you to control all of your devices, however, with a little bit of help from Google, I came across their web-app, which lives at <a href="https://my.hivehome.com">my.hivehome.com</a>. This pretty much replicates the iPhone app, however, some features of it are disabled, like the cameras - more on this later.
</p>

<p>
    The interesting part of the web-app shows its real colours when your using Google Chrome, and their Web Inspector. Clicking on the "Network" tab, ensuring it's Recording the Network Log, and the "Preserve Log" option is enabled, will allow us to see what's happening.
</p>

<p>
    Whilst performing a login attempt using your credentials, you can see the requests the web-app is making, and more importantly, the endpoints, headers and data sent. The below is what we see:
</p>

<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ asset('assets/img/blog/hive-home-rest-api/hive-app-login-request.png') }}" class="lazyload" />

<h3>Authentication</h3>
<p>
    Now we know that the web-app utilises an "undiscovered" API, I decided to pull out my favourite app for investigating things like this, <a href="https://www.postman.com">Postman</a>. Postman allows us to easily replicate any kind of request, i.e. GET, POST, etc, and see their responses.
</p>

<p>
    One of the first things we need to do is to be able to authenticate ourselves in order to obtain a <strong>token</strong> which will be used throughout all other requests.
</p>

<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ asset('assets/img/blog/hive-home-rest-api/postman-authentication-request.png') }}" class="lazyload" />

<p>
    From the above, you can see that the POST endpoint we've hit for authentication is <code>https://beekeeper.hivehome.com/1.0/global/login</code>, and we've added some JSON raw body to the request which replicates exactly what was seen within the web-app login request, shown in the image within the Capturing section above.
</p>

<p>
    If successful, what this returns is a JSON object which contains all the data we need, specifically the <strong>token</strong> field. We need to take a copy of this token to be used in further requests. At this stage I'm unsure of how long the token lives for, so, logging in each time you want to make a request ensures the token won't have expired.
</p>

@include('pages.blog.articles.includes.advert')

<p>
    The other data in the response is also important, as it lists all the available devices attached to your account, and with that, their <strong>id</strong>'s, which are required within subsequent device-based requests. You'll probably want to make a copy of the response so you're able to target the correct devices in the next section.
</p>

<h3>Requests</h3>
<p>
    Now we've got the token, we need to remember to add a header parameter named <strong>Authorization</strong>, with the <strong>token</strong> as the value to every subsequent request that isn't authentication.
</p>

<h3>Replication</h3>
<p>
    For this example, I'm going to simply use the "API" to switch on and off a light I have placed in my lounge. For the sake of this, let's say the <strong>id</strong> of this device is <code>abc-123</code>.
</p>

<p>
    Firstly, I did exactly what I wanted using the web-app and was able to learn the endpoints required (Using the Capturing method above) for handling the change of the lights state. This showed that I needed to hit the endpoint <code>https://beekeeper.hivehome.com/1.0/nodes/activeplug/abc-123</code>, (Ensuring the endpoint is appended with the device <strong>id</strong>) but with varying JSON body content depending on the state required.
</p>

<p>
    For switching the light <strong>on</strong> we had to include <code>{"status":"ON"}</code>, and for switching off it was <code>{"status":"OFF"}</code>. Let's see what switching the light on looks like, and the response we get.
</p>

<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ asset('assets/img/blog/hive-home-rest-api/postman-light-off-request.png') }}" class="lazyload" />

<p>
    You can see that the request returns a <code>200</code>-status code, which means it was successful. Here's a little video of it in action:
</p>

@include('pages.blog.articles.includes.wistia', ['videoId' => '7tvsou0pfa'])

<p>
    You can use this method to replicate all the functions the web-app has; however, the camera required some further investigation.
</p>

<h3>MITM</h3>
<p>
    I knew that the iPhone app has the ability to change the status of the camera, so, I decided to MITM (<a href="https://en.wikipedia.org/wiki/Man-in-the-middle_attack">Man in the Middle</a>) attack myself, in order to see the requests, and body, the iPhone was making to the endpoint.
</p>

<p>
    To do this, I used a bit of software called <a href="https://mitmproxy.org">mitmproxy</a>. I started an instance of this using Docker on my laptop, specifically using this command <code>docker run --rm -it -p 8080:8080 -p 127.0.0.1:8081:8081 mitmproxy/mitmproxy mitmweb --web-iface 0.0.0.0</code>, then followed the documentation on their website and setup my iPhone to utilise this as a proxy, thus sending all my data via the application. Note; there were some specific steps involve to allow SSL traffic to be tracked, which is covered within their documentation.
</p>

@include('pages.blog.articles.includes.advert')

<p>
    Once this was setup, I opened my laptop browser to <a href="http://0.0.0.0:8081">http://0.0.0.0:8081</a> so I'm able to see all incoming requests, then used my iPhone to open the Hive app and click through until the camera was activated. The below is the result I got.
</p>

<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ asset('assets/img/blog/hive-home-rest-api/mitm-camera-enable-request.png') }}" class="lazyload" />

<p>
    What you can see from the above is the request that was made, the endpoint that was hit <code>https://beekeeper-uk.hivehome.com/1.0/nodes/hivecamera/abc-123</code> and the JSON body content that was needed to turn <strong>on</strong> the camera <code>{"mode":"ARMED"}</code>. Turning off the camera requires you to use the following content <code>{"mode":"PRIVACY"}</code>.
</p>

<p>
    We can use the same method above to find out all the endpoints that are used within the app.
</p>

<h3>PHP</h3>
<p>
    Now we've managed to compile a list of the endpoints, headers and parameters we need in order to perform the required requests, it was time to convert these from Postman, to PHP.
</p>

<p>
    We're going to utilise <a href="http://docs.guzzlephp.org/en/stable">Guzzle</a> in this as it's a market leader in making requests via PHP, and I'm also going to assume that the package (guzzlehttp/guzzle) has been loaded using <a href="https://getcomposer.org/">Composer</a>.
</p>

<p>
    This example will show what's needed from a PHP point of view for <strong>Authentication</strong>, which will return the <strong>token</strong> and other account specific information:
</p>

<pre><code class="language-php">use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions

$client = new Client([
    'headers' => [
        'Accept'       => '*/*',
        'Content-Type' => 'application/json',
        'Origin'       => 'https://my.hivehome.com',
    ]
]);

$response = $client->post(
    'https://beekeeper.hivehome.com/1.0/global/login',
    [
        RequestOptions::JSON => [
            'username' => 'name@email.com',
            'password' => 'password',
            'devices'  => true,
            'products' => true,
            'actions'  => true,
            'homes'    => true,
        ],
    ]
);

$data = json_decode(
    (string) $response->getBody()
);

$token = $data->token; // Example: eyJraWQiOiI4Wjgza2EwZE9lSk9p
</code></pre>

<p>
    With the above <strong>token</strong>, we're now able to make subsequent requests, so, like the example further up the page, this snippet will switch a light <strong>on</strong>, but using PHP:
</p>

<pre><code class="language-php">use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions

$client = new Client([
    'headers' => [
        'Accept'        => '*/*',
        'Content-Type'  => 'application/json',
        'Origin'        => 'https://my.hivehome.com',
        'Authorization' => 'eyJraWQiOiI4Wjgza2EwZE9lSk9p', // Token, as returned above.
    ]
]);

$response = $client->post(
    'https://beekeeper.hivehome.com/1.0/nodes/activeplug/abc-123',
    [
        RequestOptions::JSON => [
            'status' => 'ON',
        ],
    ]
);

$code = $response->getStatusCode(); // 200
</code></pre>

<p>
    And voila, it did what it was designed to do.
</p>

<h3>Conclusion</h3>
<p>
    While this is not a public facing, official API, it's not using it in any other way different to how the Hive web-app uses it, however, please bear in mind that as this is not official, Hive control how it works and could shut it down at any time.
</p>

<p>
    It's very useful for us programmers especially, to be able to integrate with things like this, so, hopefully they will eventually release a public facing Rest API.
</p>

<p>
    Feel free to <a href="{{ \Config::get('site.social.streams.twitter.url', '#') }}" title="Send me a Tweet">Tweet Me</a> if you have any questions or need any help.
</p>

<h3>Package</h3>
<p>
    I've since created a PHP composer package which allows you to do all the above, but in a nice easy way, included in your application using Composer. You're able to see this using the following link: <a href="https://packagist.org/packages/kan-agency/hive-php-api">https://packagist.org/packages/kan-agency/hive-php-api</a>.
</p>