<p>Recently I have been working on a couple of side projects to further expand my knowledge of JavaScript. These are random ideas that I feel would create challenging tasks for me to complete, whilst giving me a solid learning experience.</p>

@include('pages.blog.articles.includes.advert')

<h3>Particles</h3>
<p>After seeing another web developer that had created a particle effect sphere using only the HTML5 canvas and JavaScript, I challenged myself with reproducing a similar version that was made using jQuery. The method for creating the particles is fairly simple, however, the calculation to place the particles within the canvas is where it gets complex. Knowledge of mathematical methods like sin and cos were used, and obviously pi too.</p>
<p>I’ve not used those methods before in any project, and if I’m honest, the last time I can recall even talking about them would be in a maths lesson during my GCSE’s – a long time ago. I had to do quite a bit of research to be able to understand what each did, but with the help of the other web developers code to reference I was able to complete my challenge.</p>
<p>The experiment is currently only working on Desktops as it requires some serious memory to be able to calculate the animations.</p>

<h3>Eye</h3>
<p>As a personal challenge, I wanted to make use of the mouse tracking functionality built into JavaScript. What better way to do this than by re-creating a very basic human eye which follows your every move?</p>
<p>The biggest problem I came across was getting the mouse position relative to the eye container. It was all well and good getting the position of the mouse in respect to the screen, but to calculate it to be relative to an element took a bit of digging around the web and reading guides. In the end it was a combination of subtraction and addition of offsets and widths which gave me the values I needed to animate the retina in the correct way.</p>
<p>This experiment makes use of jQuery and is linked to the mouse, so this would obviously only work on devices that have mice.</p>
