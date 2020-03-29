<p><a href="https://circleci.com" title="CitcleCI">CircleCI</a> is a very powerful Continuious Integration tool, and it already seemlessly integrates with <a href="https://github.com" title="GitHub">GitHub</a>, however, I've always struggled to understand how to setup the CI to create builds when a tag is created, and add that build to the tag release on GitHub, until now.</p>

<p>To make things simpler in this post, I'm going to assume you've already got methods of creating a build, whether it be <a href="http://ant.apache.org" title="Apache Ant">Apache Ant</a> for a PHP project, or something else for an iOS application, for example.</p>

@include('pages.blog.articles.includes.advert')

<p><strong>This method should work on any project, whether it be a GoLang application, a PHP website, or even a static HTML site.</strong></p>

<h3>Demo</h3>
<p>We all know you like videos, so, here's one that demos the below process:</p>

@include('pages.blog.articles.includes.wistia', ['videoId' => '7790hytqfa'])

<h3>Setup</h3>
<p>In order to use the GitHub API, you'll need to firstly generate a new API key, which can be done via your <a href="https://github.com/settings/tokens/new" title="Generate New GitHub API Token">account settings</a>. Once you've generated the key, you'll need to add it to the CircleCI project environment variables, naming it <code>GITHUB_TOKEN</code>.</p>

<h3>Configuration Parts</h3>
<p>Here are the parts that build up the CircleCI configuration file, named circle.yml, which is placed within the root of the project:</p>

<p>The first thing that needs to happen here is to install the GoLang application called <a href="https://github.com/tcnksm/ghr" title="ghr">ghr</a>. This is a very lightweight package that allows the creation of GitHub Releases and the uploading of artefacts:</p>

<pre><code class="language-yaml">dependencies:
  pre:
    - go get github.com/tcnksm/ghr
</code></pre>

<p>Once that's complete, the package needs to be created using a build service, in this case it's Apache Ant:</p>

<pre><code class="language-yaml">compile:
  override:
    - ant package
</code></pre>

<p>And then finally the deployment step is listening out for a fixed <a href="http://semver.org" title="Semantic Versioning">semver</a> version in order to publish the release to GitHub, for example <code>1.0.0</code>:</p>

<pre><code class="language-yaml">deployment:
  release:
    tag: /(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)/
    commands:
      - ghr -t $GITHUB_TOKEN -u $CIRCLE_PROJECT_USERNAME -r $CIRCLE_PROJECT_REPONAME --replace `git describe --tags` output/
</code></pre>

<h3>Complete Configuration</h3>
<p>Brining that all together makes the complete configuration file:</p>

<pre><code class="language-yaml">dependencies:
  pre:
    - go get github.com/tcnksm/ghr

compile:
  override:
    - ant package

deployment:
  release:
    tag: /(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)/
    commands:
      - ghr -t $GITHUB_TOKEN -u $CIRCLE_PROJECT_USERNAME -r $CIRCLE_PROJECT_REPONAME --replace `git describe --tags` output/
</code></pre>

<h3>Just Send It</h3>
<p>Now we've got the project setup, we simply need to create a tag on the project, and push it up to GitHub which should trigger CircleCI to create a build. Once the build is complete it should be uploaded to the GitHub Release.</p>

<p>Feel free to <a href="{{ \Config::get('site.social.streams.twitter.url', '#') }}" title="Send me a Tweet">Tweet Me</a> if you have any questions or need any guidance.</p>
