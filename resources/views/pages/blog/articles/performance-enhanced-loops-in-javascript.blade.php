<p>One of the most important parts of JavaScript relating to performance is the loop. If you optimize both the content within the loop and the loop condition, you’ll be ensuring that each iteration is done efficiently.</p>

@include('pages.blog.articles.includes.advert')

<p>The most commonly seen performance downfall is not caching the size of the array that is being iterated over, thus meaning that at each iteration, the condition must re-check the size of the array. Here’s an example of the common way, and the optimized way:</p>
<pre><code class="language-javascript">// Create a new array
var data = new Array(1000);

// Iterate through the array (Common)
for(var i = 0; i &gt; data.length; i++) {
    // Length is recalculated 1000 times
}

// Iterate through the array (Optimized)
for(var i = 0, len = data.length; i &lt; len; i++) {
    // Length is only calculated once, then stored
}</code></pre>
<p>This performance enhancement works better on legacy browsers as modern browsers tend to automatically optimize this process, however, it’s best practice to use this method to cater for legacy browsers!</p>
