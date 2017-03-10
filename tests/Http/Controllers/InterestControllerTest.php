<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Interest\Command\InterestHandler;
use App\Http\Controllers\InterestController;
use App\Tests\AbstractAppTestCase as TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.interest
 */
class InterestControllerTest extends TestCase
{
    private $handler;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->handler = Mockery::mock(InterestHandler::class);
        $this->controller = new InterestController(
            $this->handler
        );
    }

    private function createRequest()
    {
        return Request::create(
            '/api/interest/register',
            'POST',
            [
                'email' => 'joe.bloggs@email.com',
            ]
        );
    }

    public function formStateProvider()
    {
        return [
            ['complete'],
            ['incomplete'],
            ['spam'],
            ['validation'],
        ];
    }

    /**
     * @dataProvider formStateProvider
     */
    public function testPostedFormHasCorrectParams($state)
    {
        $request = $this->createRequest();

        switch ($state) {
            case 'complete':
                $this->handler->shouldReceive('handle')->andReturn(true)->once();
                break;
            case 'incomplete':
                $this->handler->shouldReceive('handle')->andReturn(false)->once();
                break;
            case 'spam':
                $this->handler->shouldReceive('handle')->andThrow(SpamException::class)->once();
                break;
            case 'validation':
                $this->handler->shouldReceive('handle')->andThrow(ValidationException::class)->once();
                break;
        }

        $response = $this->controller->__invoke($request);
        $data = $response->getData();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($data->command->email, 'joe.bloggs@email.com');
    }

    public function testValidFormComplete()
    {
        $request = $this->createRequest();

        $this->handler
            ->shouldReceive('handle')
            ->andReturn(true)
            ->once();

        $view = $this->controller->__invoke($request);
        $data = $view->getData();

        $this->assertTrue($data->complete);
        $this->assertEmpty($data->errors);
    }

    public function testHoneypotFailurePretendsToBeComplete()
    {
        $request = $this->createRequest();

        $this->handler
            ->shouldReceive('handle')
            ->andThrow(SpamException::class)
            ->once();

        $view = $this->controller->__invoke($request);
        $data = $view->getData();

        $this->assertTrue($data->complete);
    }

    public function testValidationFailure()
    {
        $request = $this->createRequest();

        $exception = ValidationException::withErrors([
            'name' => 'required',
        ]);

        $this->handler
            ->shouldReceive('handle')
            ->andThrow($exception)
            ->once();

        $view = $this->controller->__invoke($request);
        $data = $view->getData();

        $this->assertFalse($data->complete);
        $this->assertEquals(
            $exception->getErrors(),
            (array) $data->errors
        );
    }
}
