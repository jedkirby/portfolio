<p>Recently I’ve developed a control panel for my server so I’m able to manage all the websites I control using a simple interface. One of the main features is enabling me to update Apache’s virtual host files without ever going into the server and manually editing the vhosts.conf file.</p>

<h3>Problem</h3>
<p>As I’m a very organised person, I wanted to split each of the virtual hosts into separate configuration files and not have them all crammed into a single vhosts.conf file. Doing a search online return very little help about how to do this, but luckily I was able to workout a very simple yet effective solution.</p>

<h3>Solution</h3>
<p>Inside the Apache httpd.conf file, near the bottom, there is a section about virtual hosts. To enable your server to use the organised virtual host structure, follow this simple guide:</p>
<p>Firstly is the section which will enable name based virtual hosting, feel free to customize the IP address (*) and the port (80):</p>
<pre><code class="language-apacheconf">NameVirtualHost *:80</code></pre>
<p>Secondly you should give a default directory for all sites to be served from if there isn’t a virtual host setup for the requested host name:</p>
<pre><code class="language-apacheconf">&lt;VirtualHost *:80&gt;
    DocumentRoot /var/www/html
&lt;/VirtualHost&gt;</code></pre>
<p>And finally, the magic. You need to create a folder within the installation directory of Apache (/etc/httpd) naming it something like “vhosts”. Within that folder you can add separate virtual host configuration files and name them accordingly, such as: foo.com.conf, bar.co.uk.conf – Just be sure to include the “.conf” at the end of each file. Back within the httpd.conf, add the following lines to automatically include all virtual host configurations:</p>
<pre><code class="language-apacheconf">Include vhosts/*.conf</code></pre>

<h3>Sample Virtual Host Configuration File</h3>
<p>There is a comprehensive guide to configuring virtual hosts on the Apache website, however, here is a very simple sample of the type of content in one of the configuration files, lets look at foo.com.conf for example:</p>
<pre><code class="language-apacheconf">&lt;VirtualHost *:80&gt;
    ServerName www.foo.com
    ServerAlias foo.com
    DocumentRoot /var/www/vhosts/foo.com/public
    ErrorLog /var/www/vhosts/foo.com/logs/error.log
    ServerAdmin admin@foo.com
&lt;/VirtualHost&gt;</code></pre>

<h3>Overview</h3>
<p>The control panel on my server simply generates a configuration file within the vhosts directory for each site I’ve currently got set up. This organizes the virtual host directory and gives me a simple structure if I’m ever required to debug.</p>
