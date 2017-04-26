<p>When I started working for <a href="http://www.blitzgamesstudios.com" target="_blank">Blitz Games Studios</a> (Blitz) in the Summer of 2011 I swiftly found that their preferred choice of framework was <a href="http://codeigniter.com" target="_blank">CodeIgniter</a> (CI). I had next to no experience with frameworks so this was a great opportunity for me to broaden my knowledge. This is a bit about my first encounter with this framework and my workarounds to make the most of it:</p>

<p>During learning and creating new websites using the CI framework I discovered Blitz used multiple environments for the websites to enable me to develop locally, test on a staging server and – once finalised - push to the live server. CI gives you the ability to have separate configuration files for different environments, however, the environment global variable is user defined. This means you have to manually change it to enable the site to switch between each environment; a pain to keep up-to-date, especially when working with three different environments and using version source control.</p>

<p>Having encountered this problem a lot, this led me to create a simple module that automatically determines the environment based on a user-defined part of the URL. It can also apply specific application & system paths and set the error reporting based on the URL used to reach the site.</p>

<p>However, this unearthed a new problem – “How to choose between which URLs to detect?”. With a bit of <a href="http://stackoverflow.com/questions/13266507/prefixed-suffixed-environmental-domain-names/13271173" target="_blank">help from a question I posted on Stack Overflow</a> and the responses I received, I narrowed down the choices to either a Prefixed or Suffixed URL, as this is generally what’s used within web development. I decided to give the user the option between these two choices with a simple switch as the variable.</p>

<p>Now, the coding side of things – firstly, the function accepts only one parameter which is either <strong>prefix</strong> or <strong>suffix</strong>, but defaults to <strong>prefix</strong>. Secondly, the function splits up the URL into segments which are stored in an array. It does this by searching for the periods (.) in the URL string and breaking it up when it finds each one. Finally, the switch will choose the required case based on the domain environment (which is forced to lowercase to cut-out inconsistencies); it’ll return either the first (Prefixed) or last (Suffixed) item in the array. For those that need more detail, this is the functions code:</p>

<pre><code class="language-php">function domains_determine_uri($domain_environment = 'prefix')
{

    $http_host = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : FALSE);
    $http_split = ($http_host ? explode('.', $http_host) : FALSE);

    switch(strtolower($domain_environment))
    {
        case 'prefix':
            $domain_uri = $http_split[0];
            break;
        case 'suffix':
            $domain_uri = end($http_split);
            break;
        default:
            exit('The domain environment has not been set correctly, please use either prefix or suffix.'); 
    }

    return (isset($domain_uri) ? $domain_uri : FALSE);

}</code></pre>

<p>Now it’s just a simple case of using a switch statement to choose between the different environments, this uses either the prefix or suffix of the domain depending on your set-up. For this example we’re using the prefix option so these are our URLs:</p>

<ul>
    <li>http://dev.site.com</li>
    <li>http://stage.site.com</li>
    <li>http://site.com</li>
</ul>

<p>This is the switch statement we’re using; you can see you’re able to define different system & application paths for each environment:</p>

<pre><code class="language-javascript">$domains['environment'] = 'prefix';

switch( domains_determine_uri( $domains['environment'] ) )
{
    case 'dev':
        define('ENVIRONMENT', 'development');
            $system_path = 'system';
            $application_folder = 'application';
            break;
    case 'stage':
        define('ENVIRONMENT', 'staging');
            $system_path = 'system';
            $application_folder = 'application';
            break;      
    default:
        define('ENVIRONMENT', 'production');
            $system_path = 'system';
            $application_folder = 'application';
}</code></pre>

<p>From the above you can see the first case is ‘dev’ which the URL <i>http://dev.site.com</i> would use. The second is ‘stage’ which would use the URL <i>http://stage.site.com</i>, and the third is the default one. So anything that isn’t one of the above cases will use this, i.e. <i>http://site.com</i> or any other sub-domains.</p>

<p>This CI module is just one part of the problem, though. You need to be able to modify your <a href="http://httpd.apache.org/docs/2.2/vhosts/" target="_blank">Virtual Hosts</a> in Apache and your <a href="http://help.hardhathosting.com/question.php/11" target="_blank">PC</a> or <a href="http://www.names.co.uk/support/new/servers/1132-how_to_edit_the_hosts_file_in_mac_os_x.html" target="_blank">MAC</a> local host file to enable the multiple URLs that are required for this module to work correctly.</p>

<p>I’ve hosted this module on <a href="https://github.com/jedkirby/ci-multi-environments" target="_blank">GitHub</a> for you to view, download, and fork. Please feel free to use the <a href="{{ \URL::to('contact') }}">contact</a> form if you need any help with this or have any further questions. Check back for any further updates I have on this topic; I’ll be adding more tips and tricks as I uncover them.</p>
