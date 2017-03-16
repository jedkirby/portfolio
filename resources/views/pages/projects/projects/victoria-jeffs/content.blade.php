<h3>Building the Responsive Layout</h3>
<p>As set in our initial goals, we wanted the Victoria Jeffs site to have complete content parity and be accessible to all users on all devices and screen resolutions. We designed a custom 1280px fluid grid system using the <a href="http://sass-lang.com" target="_blank">SASS preprocessor</a> to allow for a modular column system that would streamline the construction of the site.</p>
<p>We took a device-agnostic approach to how the layout reacted at different resolutions but also employed tailored breakpoints specifically for the most common devices to allow for the best possible experience. On smaller resolutions our intention was to introduce users to the search functionality as soon as possible and so utilised an off-canvas navigation to create breathing space for the navigation to function while introducing a cohesive content hierarchy to the rest of the site.</p>

<h3>Connecting the Content Management System</h3>
<p>The requirement from Victoria Jeffs was that they needed the ability to manage dynamic content through a secure interface.</p>
<p>The task was to provide the ability for the management of; properties, news, articles, testimonials and staff profiles. Along side these specific requirements, the <a href="{{ route('project', 'admin-panel') }}">Admin Panel</a> that was developed comes pre-built with user, role and permission management functionality which added further flexibility to the end user(s).</p>
<p>The result of encorporating the <a href="{{ route('project', 'admin-panel') }}">Admin Panel</a> into this build enabled Victoria Jeffs to do the following:</p>
<ul>
    <li>Manage admin users, roles and permissions</li>
    <li>Manage testimonials and news articles</li>
    <li>Manage staff profiles and roles</li>
    <li>Manage properties, property locations &amp; types</li>
    <li>Control specific parts of their content managed pages; e.g. slideshows</li>
</ul>

<h3>Final Optimization</h3>
<p>After the site had been signed off, the front-end developer I worked with throughout the project, <a href="http://hi-im-si.com" target="_blank">Simon Shahriveri</a>, and I spent a couple of evenings running through the site and optimising images, minifying JavaScript and StyleSheets, and reducing the amount of requests in a bid to speed up the inital loading of the site.</p>
<p>Simon implemented <a href="https://github.com/BBC-News/Imager.js" target="_blank">Imager</a>, which has been developed by The BBC, which simply means that any images which are not visible within the inital viewport are not initially loaded, thus reducing the amount of requests on page load. Once the user scrolls down the page the images are asynchronously loaded into the page.</p>

<h3>Conclusion</h3>
<p>The project spanned over 6 months and the services involved within the build are, but not limited to:</p>
<ul>
    <li>Design</li>
    <li>Front-end development</li>
    <li>Back-end development</li>
    <li>Hosting configuration</li>
</ul>
<p>If the above has interested you, feel free to <a href="{{ route('contact') }}">request more information</a> about this project and I'll happily get back to you.</p>
