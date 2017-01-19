<?php

namespace App\Http\Controllers;

use Dynamify\PhpSdk\Dynamify;
use App\Blog\TagManager as Tag;
use Carbon\Carbon;
use SocialLinks\Page;

class BlogController extends RootController
{
    public static function articles($limit = false)
    {
        $articles = [
            'digital-ocean' => [
                'title' => 'Digital Ocean',
                'date' => Carbon::createFromDate(2014, 6, 9),
                'snippet' => 'I found out about Digital Oceans (DO) existence through a colleague at work, I wasn’t initially interested in it as I already had a Virtual Private Server (VPS) with another provider – Oh how that was about to change',
                'content' => view('pages.blog.articles.digital-ocean'),
                'image' => cached_asset('assets/img/blog/digital-ocean.jpg'),
                'keywords' => ['VPS', 'Linux', 'Digital Oceal', 'DO'],
                'tags' => [
                    Tag::get('servers'),
                    Tag::get('apache'),
                    Tag::get('mysql'),
                    Tag::get('nginx'),
                ],
            ],
            'multiple-apache-virtual-host-configuration-files' => [
                'title' => 'Multiple apache virtual host configuration files',
                'date' => Carbon::createFromDate(2014, 1, 16),
                'snippet' => 'Recently I’ve developed a control panel for my server so I’m able to manage all the websites I control using a simple interface. One of the main features is enabling me to update Apache’s virtual host files without ever',
                'content' => view('pages.blog.articles.multiple-apache-virtual-host-configuration-files'),
                'image' => cached_asset('assets/img/blog/apache-virtual-hosts.jpg'),
                'keywords' => ['vhosts', 'Virtual Hosts'],
                'tags' => [
                    Tag::get('servers'),
                    Tag::get('apache'),
                ],
            ],
            'oculus-rift-virtual-experience-trials' => [
                'title' => 'Oculus rift virtual experience trials',
                'date' => Carbon::createFromDate(2013, 6, 28),
                'snippet' => 'A few weeks ago I heard of an opportunity to give an Oculus Rift a run for its money during some trials that were being undertaken at Blitz Games Studios. I quickly added my name to the list of potential candidates for the trials and was lucky enough to get a slot. I’d heard quite',
                'content' => view('pages.blog.articles.oculus-rift-virtual-experience-trials'),
                'image' => cached_asset('assets/img/blog/oculus-rift-headset.jpg'),
                'keywords' => ['Oculus Rift', 'Unity', 'Virtual Reality', 'VR', 'Museum of the Microstar', 'Tuscany World', 'Team Fortress'],
                'tags' => [
                    Tag::get('games'),
                ],
            ],
            'experiments' => [
                'title' => 'Experiments',
                'date' => Carbon::createFromDate(2013, 6, 6),
                'snippet' => 'Recently I have been working on a couple of side projects to further expand my knowledge of JavaScript. These are random ideas that I feel would create challenging tasks for me to complete, whilst giving me a solid learning experience',
                'content' => view('pages.blog.articles.experiments'),
                'image' => false,
                'keywords' => ['Canvas', 'Eye', 'HTML5', 'jQuery', 'Maths', 'Particles', 'PI', 'Sin', 'Cos', 'Labs', 'Experiments', 'Partical Generator'],
                'tags' => [
                    Tag::get('just-for-fun'),
                ],
            ],
            'my-route-into-a-career-in-programming' => [
                'title' => 'My route into a career in programming',
                'date' => Carbon::createFromDate(2013, 4, 23),
                'snippet' => 'I had always been fascinated with music, particularly with playing the drums, and thrived to start a band. Whilst taking a music module at Henley, two other music-talented friends and I decided to create this band. We named it “Panini”. We use to practice our songs once a week during our lunch break, whilst in',
                'content' => view('pages.blog.articles.my-route-into-a-career-in-programming'),
                'image' => false,
                'keywords' => ['Career', 'History', 'Programming'],
                'tags' => [],
            ],
            'vuvens-new-company-direction' => [
                'title' => 'Vuven’s new company direction',
                'date' => Carbon::createFromDate(2013, 4, 11),
                'snippet' => 'April 2013 sees the new release of Vuven, for which I am a front and back-end web developer for. Its re-brand gives a whole new direction to the company whom originally focused on creating a platform to allow users to find and publish entertainment businesses around the UK. It’s now moved into an umbrella company',
                'content' => view('pages.blog.articles.vuvens-new-company-direction'),
                'image' => cached_asset('assets/img/blog/vuven.jpg'),
                'keywords' => ['CSS3', 'HTML5', 'Projects'],
                'tags' => [],
            ],
            'learn-to-code-for-free-with-these-5-useful-resources' => [
                'title' => 'Learn to code for free with these 5 useful resources',
                'date' => Carbon::createFromDate(2013, 3, 14),
                'snippet' => 'The likes of Mark Zuckerberg and Bill Gates have both agreed that understanding how to code is the new literacy. Even non-techies are now getting involved, with singer Will.I.Am saying he’s currently taking classes. You have no excuses, If you’re reading this, then you obviously',
                'content' => view('pages.blog.articles.learn-to-code-for-free-with-these-5-useful-resources'),
                'image' => false,
                'keywords' => ['Coding', 'Free', 'Useful'],
                'tags' => [],
            ],
            'performance-enhanced-loops-in-javascript' => [
                'title' => 'Performance enhanced loops in JavaScript',
                'date' => Carbon::createFromDate(2013, 3, 12),
                'snippet' => 'One of the most important parts of JavaScript relating to performance is the loop. If you optimize both the content within the loop and the loop condition, you’ll be ensuring that each iteration is done efficiently',
                'content' => view('pages.blog.articles.performance-enhanced-loops-in-javascript'),
                'image' => false,
                'keywords' => ['JavaScript', 'Enhancing', 'Guide', 'Performance', 'Useful'],
                'tags' => [],
            ],
            'todays-date-automated-on-twitter' => [
                'title' => 'Today’s date, automated on Twitter',
                'date' => Carbon::createFromDate(2013, 1, 7),
                'snippet' => 'During the 2012 Christmas break I came up with a small project. It included stuff that I had no experience with so was definitely invaluable learning experience. The project made use of the Twitter API and Cron Jobs, both of which I’d not used before',
                'content' => view('pages.blog.articles.todays-date-automated-on-twitter'),
                'image' => false,
                'keywords' => ['Cron Jobs', 'Short Project'],
                'tags' => [
                    Tag::get('just-for-fun'),
                ],
            ],
            'youre-officially-for-sale-on-instagram' => [
                'title' => 'You’re officially for sale on Instagram',
                'date' => Carbon::createFromDate(2012, 12, 19),
                'snippet' => 'As of January 16th 2013 Instagram‘s new terms of service and privacy policy will take effect. Some of the changes that have been made might make you think twice about signing up or continuing to use their service',
                'content' => view('pages.blog.articles.youre-officially-for-sale-on-instagram'),
                'image' => false,
                'keywords' => ['Instagram', 'Flickr', 'Privacy', 'TOS'],
                'tags' => [],
            ],
            'the-new-myspace-heres-my-view' => [
                'title' => 'The new Myspace: Here is my view',
                'date' => Carbon::createFromDate(2012, 12, 7),
                'snippet' => 'I know most of you will be thinking "Uhh, not another social network to keep track of." but hold out – Although the New Myspace is fairly basic in what it can do at the moment, it still boasts some impressive user interfaces',
                'content' => view('pages.blog.articles.the-new-myspace-heres-my-view'),
                'image' => cached_asset('assets/img/blog/the-new-myspace-heres-my-view.jpg'),
                'keywords' => ['Myspace'],
                'tags' => [
                    Tag::get('social-media'),
                ],
            ],
            'breaking-nested-loops-in-javascript' => [
                'title' => 'Breaking nested loops in JavaScript',
                'date' => Carbon::createFromDate(2012, 11, 28),
                'snippet' => 'In JavaScript you may sometimes find yourself having multi-dimensional arrays which you are required to search through to check for a value match. There are quite a few different methods you can use to handle this kind of problem',
                'content' => view('pages.blog.articles.breaking-nested-loops-in-javascript'),
                'image' => false,
                'keywords' => ['Time Saver', 'Useful'],
                'tags' => [],
            ],
            'facebook-photo-sync' => [
                'title' => 'Facebook is set to automatically upload your photos',
                'date' => Carbon::createFromDate(2012, 11, 20),
                'snippet' => 'Facebook has had this "auto-upload" feature enabled on Android for a couple of months now, but recently the company announced that they have figured out how to enable background auto-uploads on iOS. Although this feature',
                'content' => view('pages.blog.articles.facebook-photo-sync'),
                'image' => false,
                'keywords' => ['Android', 'iOS', 'Photo Sync', 'Apple', 'iPhone'],
                'tags' => [],
            ],
            'a-trip-through-space-with-a-google-experiment' => [
                'title' => 'A trip through space with a Google experiment',
                'date' => Carbon::createFromDate(2012, 11, 19),
                'snippet' => 'Earlier this month Google released a Chrome experiment to take you on a trip through space. It gives you the opportunity to view our stellar neighbourhood in a way you have never seen',
                'content' => view('pages.blog.articles.a-trip-through-space-with-a-google-experiment'),
                'image' => cached_asset('assets/img/blog/a-trip-through-space-with-a-google-experiment.jpg'),
                'keywords' => ['Aaron Koblin', 'Chrome', 'CSS3D', 'Experiment', 'Mass Effect', 'Sam Hulick', 'Space', 'Web Audio', 'WebGL'],
                'tags' => [],
            ],
            'your-passwords-are-never-good-enough' => [
                'title' => 'Your passwords are never good enough',
                'date' => Carbon::createFromDate(2012, 11, 16),
                'snippet' => 'Back in August of this year, Wired reporter Mat Honan had his "entire digital life destroyed" in the span of just an hour. His post on covers the ordeal in great depth, including some incredibly valuable tips for protecting',
                'content' => view('pages.blog.articles.your-passwords-are-never-good-enough'),
                'image' => false,
                'keywords' => ['Mat Honan', 'Passwords', 'Security', 'Wired'],
                'tags' => [],
            ],
            'codeigniter-multiple-development-environments' => [
                'title' => 'CodeIgniter multiple development environments',
                'date' => Carbon::createFromDate(2012, 11, 12),
                'snippet' => 'When I started working for Blitz Games Studios (Blitz) in the Summer of 2011 I swiftly found that their preferred choice of framework was CodeIgniter (CI). I had next to no experience with frameworks so this was a great opportunity',
                'content' => view('pages.blog.articles.codeigniter-multiple-development-environments'),
                'image' => false,
                'keywords' => ['CI', 'Code Igniter', 'Coding', 'Plugin', 'Time Saver', 'Useful'],
                'tags' => [],
            ],
        ];

        return  $limit ? array_slice($articles, 0, $limit) : $articles;
    }

    public function getArticles(Dynamify $dynamify)
    {
        $this->setTitle('Blog');
        $this->setDescription('From time to time I create articles. These could range from server configuration guides to life experiences. Feel free to get to know me more by reading a few of my articles.');
        $this->setKeywords('blog, articles, life stories, guides, php, mysql, javascript');

        return view('pages.blog', [
            'articles' => $dynamify->entity('blog.post')->all(),
        ]);
    }

    public function getSingle($slug)
    {
        if (!($article = array_get(static::articles(), $slug, false))) {
            abort(404);
        }

        // Create the social page information
        $social = new Page([
            'url' => \URL::current(),
            'title' => array_get($article, 'title'),
            'text' => array_get($article, 'snippet'),
            'image' => array_get($article, 'image', ''),
            'twitterUser' => \Config::get('site.meta.twitter.handle'),
        ]);

        // Combine the keywords and tags
        $keywords = array_merge(
            array_get($article, 'keywords', []),
            array_get($article, 'tags', [])
        );

        $this->setTitle(array_get($article, 'title'));
        $this->setDescription(array_get($article, 'snippet'));
        $this->setKeywords(implode(', ', array_unique($keywords)));

        return view('pages.blog.single', compact('article', 'social'));
    }
}
