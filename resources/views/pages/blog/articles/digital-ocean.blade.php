<p>I found out about Digital Oceans (DO) existence through a colleague at work, I wasn’t initially interested in it as I already had a Virtual Private Server (VPS) with another provider – Oh how that was about to change.</p>

<h3>Current VPS</h3>
<p>This had been giving me some grief from day one, primarily sporadic latency times and the occasional down time, however, I was willing to look over these issues as I’d been with them only a few months and spent a while configuring the server – not something that was easy with this provider.</p>

@include('pages.blog.articles.includes.advert')

<p>After another month of putting up with the issues (I thought these were widespread across all VPS providers – little did I know!) my provider got hit by a serious network outage, knocking all their VPS’s offline for 4 consecutive days. This was the icing on the cake for me – it was time to look else where.</p>

<h3>Time to Move</h3>
<p>During the VPS downtime, I did lots of research into various hosting providers and kept on getting referred back to DO. I found the colleague of mine who initially suggested it to me, and took his advice and started the process of signing up.</p>
<p>Within 10 minutes I was signed up, card details entered and on the edge of my seat choosing which Droplet to use. I started off using their very basic one which gave me enough to learn how they worked. First impressions: Super fast at spinning up a new Droplet, and their website UI is clean and incredibly simple to use. So far, so good.</p>

<h3>Production Setup</h3>
<p>After spending a day or two learning, it was time to get serious and configure the VPS(s) I wanted to use in production. I chose to use two separate servers; a public facing one which would be a web server, and another only accessible using the private network which would be the (jailed) database server. Setting up these two servers compared to the single one I did on my previous provider was ridiculous, the shear amount of tutorials/guides and extensive community made configuring these a breeze. Every thing I wanted to do had already been written up in a easy-to-read guide – excellent.</p>
<p>Configuration of the servers took only one evening. I even managed to transfer all my sites to be git managed and use hooks to be able to push to the server from the command line.</p>

<h3>Overview</h3>
<p>In a nutshell – extremely happy. Not only have I had absolutely ZERO down time, and unnoticeable latency times, but the speed and community currently make this provider one of the best in the industry. I highly recommenced Digital Ocean – if you’re interested in getting a VPS, use this link to get started!</p>
