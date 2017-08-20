<p>
    Heroku makes running tests and automated deployments very easy, and I thank them for that! However, there's been a long running issue of having to manually update your Typekit account with the domains of either pipeline stage apps or review apps to make custom fonts work.
</p>

<p>
    While this isn't really a huge problem, when you're working on multiple features daily, it adds an additional overhead of logging into Typekit, whitelisting the domain, and waiting for it to propagate. Something which I'd had enough of.
</p>

<p>
    I had a search around, and couldn't find anything which automatically allowed Typekit to wildcard the <code>*.herokuapp.com</code> domain, only a few frustrated people, albeit a while ago now:
</p>

<div class="article__content--twitter">
    <blockquote class="twitter-tweet" data-lang="en">
        <p lang="en" dir="ltr"><a href="https://twitter.com/typekit">@typekit</a> What&#39;s the recommendation for using Typekit with dynamic subdomains? I have a customer asking. Allow `static-*.herokuapp.com` ?</p>&mdash; Jon McCartie (@jmccartie) <a href="https://twitter.com/jmccartie/status/661953245552640000">November 4, 2015</a>
    </blockquote>
</div>

<p>
     So, I decided to learn a new technology, Python, and get into the depths of <a href="https://devcenter.heroku.com/articles/buildpacks#creating-a-buildpack" target="_blank">writing a buildpack</a>. After an evening, I had a working buildpack, of which can be found here: <a href="https://github.com/jedkirby/heroku-buildpack-typekit" target="_blank">https://github.com/jedkirby/heroku-buildpack-typekit</a>.
</p>

<p>
    As I know you all like videos, here's one that shows how smooth and simple it now is:
</p>

@include('pages.blog.articles.includes.wistia', ['videoId' => '8sdz7lk4hr'])

<p>
    There's a full guide on the <a href="https://github.com/jedkirby/heroku-buildpack-typekit">GitHub repository</a> of what's needed to get the buildpack working, and if you run into any issues, feel free to give me a shout on <a href="{{ \Config::get('site.social.streams.twitter.url', '#') }}" title="Send me a Tweet">Twitter</a>.
</p>

<p>
    Ciao.
</p>

@section('footer')

    @parent

    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

@stop
