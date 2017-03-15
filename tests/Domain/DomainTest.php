<?php

namespace App\Tests\Domain;

use App\Domain\Domain;
use App\Tests\AbstractAppTestCase as TestCase;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 */
class DomainTest extends TestCase
{
    private $config;
    private $domain;
    private $defaults = [
        'site.meta.title' => 'My Title',
        'site.meta.description' => 'My Description',
        'site.meta.keywords' => 'One, Two, Three, Four',
        'site.meta.author' => 'Joe Bloggs',
    ];

    public function setUp()
    {
        $config = Mockery::mock(Config::class);

        foreach ($this->defaults as $key => $value) {
            $config
                ->shouldReceive('get')
                ->with($key, '')
                ->andReturn($value)
                ->once();
        }

        $this->config = $config;
        $this->domain = new Domain(
            $this->config
        );
    }

    public function testDefaultsAreProvided()
    {
        $this->assertEquals($this->domain->getTitle(), 'My Title');
        $this->assertEquals($this->domain->getDescription(), 'My Description');
        $this->assertEquals($this->domain->getKeywords(), 'One, Two, Three, Four');
        $this->assertEquals($this->domain->getAuthor(), 'Joe Bloggs');
    }

    public function testCanOverwriteDefaults()
    {
        $this->domain->setTitle('My Overwritten Title');
        $this->domain->setDescription('My Overwritten Description');
        $this->domain->setKeywords('Five, Six, Seven');
        $this->domain->setAuthor('Sam Bloggs');

        $this->assertEquals($this->domain->getTitle(), 'My Overwritten Title');
        $this->assertEquals($this->domain->getDescription(), 'My Overwritten Description');
        $this->assertEquals($this->domain->getKeywords(), 'Five, Six, Seven');
        $this->assertEquals($this->domain->getAuthor(), 'Sam Bloggs');
    }

    public function testKeywordsCanTakeStringValue()
    {
        $this->domain->setKeywords('Eight, Nine, Ten');

        $this->assertEquals($this->domain->getKeywords(), 'Eight, Nine, Ten');
    }

    public function testKeywordsCanTakeArrayValue()
    {
        $this->domain->setKeywords(['Lhotse', 'Makalu', 'Manaslu', 'Gasherbrum IV']);

        $this->assertEquals($this->domain->getKeywords(), 'Lhotse, Makalu, Manaslu, Gasherbrum IV');
    }
}
