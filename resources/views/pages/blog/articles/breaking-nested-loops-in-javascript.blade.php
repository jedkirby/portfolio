<p>In JavaScript you may sometimes find yourself having multi-dimensional arrays which you're required to search through to check for a value match. There are quite a few different methods you can use to handle this kind of problem, but below is probably the neatest and most optimized process.</p>

@include('pages.blog.sections.advert')

<p>Here's a sample multi-dimensional array that we'll use as an example to search through:</p>

<pre><code class="language-javascript">var data = [
    ['lorem', 'ipsum', 'dolor'],
    ['sit', 'amet'],
    ['eli'],
    ['cras', 'sed', 'leo', 'lacinia']
];</code></pre>

<p>Now, as there are array items within an array, we'll be needing nested 'for()' loops to iterate through all the items. A very simple version, with the added ability of checking for a value match against "sed", would look like this:</p>

<pre><code class="language-javascript">for( var dataIndex = 0; dataIndex != data.length; dataIndex++ ) {

    for( var itemIndex = 0; itemIndex != data[dataIndex].length; itemIndex++ ) {

        if( data[dataIndex][itemIndex] == 'sed' )
        {

            console.log('Data item found. Data Index: ' + dataIndex + ', and Item Index: ' + itemIndex);
            break;

        }

    }

}</code></pre>

<p>The above would output to the console, the data index and item index if there is a item in any of the arrays that matches the value we're searching for. Currently, after finding the item it breaks. However, it only breaks from the first loop and continues with the parent loop. Ideally we'd like to break from both loops at once - this is where loop labels come into play.</p>

@include('pages.blog.sections.advert')

<p>By assigning each 'for()' loop a label, you can use breaks to target a specific loop and break from any nested loops automatically. Here's an example of using loop labels and breaking from the parent loop:</p>

<pre><code class="language-javascript">dataLoop: for( var dataIndex = 0; dataIndex != data.length; dataIndex++ ) {

    itemLoop: for( var itemIndex = 0; itemIndex != data[dataIndex].length; itemIndex++ ) {

        if( data[dataIndex][itemIndex] == 'sed' )
        {

            console.log('Data item found. Data Index: ' + dataIndex + ', and Item Index: ' + itemIndex);
            break dataLoop;

        }

    }

}</code></pre>

<p>Now the above will break from all the nested loops and the parent and stop searching through the array unnecessarily.</p>

<p>I've created the <a href="http://jsfiddle.net/ErwcV/5/" target="_blank">above code on JSFiddle</a> for you to play with, it's got a few more styling elements and the jQuery library, but these are not necessary. Hopefully you find this useful, but please get in touch if you come up against any problems whilst following this.</p>
