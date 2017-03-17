<?php

namespace App\Tests\Domain\Social;

use App\Domain\Social\Page;
use App\Tests\AbstractTestCase as TestCase;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 * @group domain.social
 * @group domain.social.page
 */
class PageTest extends TestCase
{
    private $page;

    public function setUp()
    {
        $config = Mockery::mock(Config::class);
        $config
            ->shouldReceive('get')
            ->with('site.social.streams.twitter.handle', '')
            ->andReturn('@handle')
            ->once();

        $this->page = new Page($config);
    }

    public function testSetsDetailsCorrectly()
    {
        $this->page->setUrl('http://test.com');
        $this->page->setTitle('Title');
        $this->page->setText('Body Text.');
        $this->page->setImage('http://test.com/img/first.png');

        $data = $this->page->get();

        $this->assertEquals($data['url'], 'http://test.com');
        $this->assertEquals($data['title'], 'Title');
        $this->assertEquals($data['text'], 'Body Text.');
        $this->assertEquals($data['image'], 'http://test.com/img/first.png');
        $this->assertEquals($data['twitterUser'], '@handle');
    }
}
