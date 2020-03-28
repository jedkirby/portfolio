<p><em>Since having completed this project, I have now turned off the cron job and closed the twitter account as it turned out the timings from my server and the twitter client API were not synchronised properly and causing issues with the tweet going out at the same time. I’m working on an alternative solution.</em></p>
<p>During the 2012 Christmas break I came up with a small project. It included stuff that I had no experience with so was definitely an invaluable learning experience. The project made use of the <a title="Twitter Developers" href="https://dev.twitter.com" target="_blank">Twitter API</a> and <a title="Cron Jobs" href="http://en.wikipedia.org/wiki/Cron" target="_blank">Cron Jobs</a>, both of which I’d not used before.</p>

@include('pages.blog.sections.advert')

<p>The project automatically tweets the date every single day in this format: “Monday 7th January, 2013″. I couldn’t figure out how to post the dates for all time zones without spamming the twitter followers. The only solution I found was to create separate twitter accounts for all the time zones - something I didn’t want to do as this was a short project, so I have limited this project to UK only.</p>
<p>How the project works is; on the Twitter account there is an application registered with Twitter which allows a script to post to the accounts timeline. This then allows server sided scripting (PHP) to connect via the Twitter API and post. I used a handy OAuth library called “tmhOAuth” to bridge the gap between the server and Twitter, you can find the library on <a title="tmhOAuth on GitHub" href="https://github.com/themattharris/tmhOAuth" target="_blank">GitHub</a>. The PHP script populates a variable with today’s date using the basic <a title="PHP Date Function" href="http://php.net/manual/en/function.date.php" target="_blank">date()</a> function, and uses the OAuth library to post the tweet to the Twitter account. One of my servers then has a cron job set-up to process the PHP script every day at 00:00.</p>
<p>The project had a lifespan of 1 day, and was completed just before the new year so the account would start from the 1st January 2013.</p>
