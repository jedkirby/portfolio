<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;

class ControllerTestCase extends TestCase
{
    protected $domain;

    public function setUp()
    {
        parent::setUp();

        $domain = Mockery::mock(Domain::class);
        $domain->shouldReceive('getTitle')->andReturn('My Title')->once();
        $domain->shouldReceive('getDescription')->andReturn('My Description')->once();
        $domain->shouldReceive('getKeywords')->andReturn('One, Two, Three')->once();
        $domain->shouldReceive('getAuthor')->andReturn('Author Bloggs')->once();

        $this->domain = $domain;
    }
}
