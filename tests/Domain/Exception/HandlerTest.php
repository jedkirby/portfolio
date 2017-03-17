<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Domain;
use App\Domain\Exception\Handler;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @group domain
 * @group domain.exception
 * @group domain.exception.handler
 */
class HandlerTest extends TestCase
{
    private $domain;
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(
            Domain::class,
            [
                'getTitle' => '',
                'getDescription' => '',
                'getKeywords' => '',
                'getAuthor' => '',
            ]
        );
        $this->handler = new Handler($this->domain);
    }

    public function uniqueStatusHandler()
    {
        return [
            [404],
            [403],
            [500],
        ];
    }

    /**
     * @dataProvider uniqueStatusHandler
     */
    public function testGenericStatuses($status)
    {
        switch ($status) {
            case 404:
                $this->domain->shouldReceive('setTitle')->with('Page Not Found')->once();
                break;
            default:
                $this->domain->shouldReceive('setTitle')->with(sprintf('%s Error', $status))->once();
        }

        $e = Mockery::mock(
            HttpException::class,
            [
                'getStatusCode' => $status,
                'getHeaders' => [],
            ]
        );

        $view = $this->handler->renderHttpException($e);
        $data = $view->getData();

        $this->assertStringEndsWith('errors/generic.blade.php', $view->getPath());
        $this->assertEquals($data['status'], $status);
        $this->assertEquals($data['id'], 'error  error__generic');
    }
}
