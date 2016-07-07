<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use App\Integrations\Instagram as InstagramIntegration;
use Pixelate\Shared\Social\Stream\Instagram as InstagramStream;

class Instagram extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:instagram';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch the latest instagram posts';

	/**
	 * The amount of posts to store.
	 * 
	 * @var integer
	 */
    const POST_LIMIT = 8;

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$instagram = new InstagramStream;
		$instagram->setAccessToken(Config::get('site.social.streams.instagram.api.access_token'));
		$instagram->setUserId(Config::get('site.social.streams.instagram.id'));

		// Attempt to get the instagram feed
		if( ($feed = $instagram->getFeed()) ){

            // Convert to posts, remove ignored posts, and limit
            $posts = $this->convertFeedToApprovedPosts($feed);

            // Store the entire feed
            InstagramIntegration::storePosts($posts);

            // Give some output
            $this->info('Instagram posts fetched!');

		} else {

            // We have an issue
            $this->info('Failed to fetch Instagram posts.');

        }

	}

    /**
     * Convert an array of instagram feeds into an array of posts, removing
     * the ignored posts and limiting.
     *
     * @param array $feed
     * @return array
     */
    private function convertFeedToApprovedPosts(array $feed)
    {
        $posts = [];
        $ignoreIds = Config::get('site.social.streams.instagram.ignore', []);
        foreach ($feed as $post) {
            $post = InstagramIntegration::createPostFromArray($post);
            if (!in_array($post->getId(), $ignoreIds)) {
                $posts[] = $post;
            }
        }
        return array_slice($posts, 0, self::POST_LIMIT);
    }

}
