<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Common\Validation\Exception\SpamException;
use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Contact\Command\ContactCommand;
use App\Domain\Contact\Command\ContactHandler;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.contact
 */
class ContactControllerTest extends AbstractControllerTestCase
{
    private $handler;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain->shouldReceive('setTitle')->with('Contact')->andReturn(true)->once();
        $this->domain->shouldReceive('setDescription')->andReturn(true)->once();

        $this->handler = Mockery::mock(ContactHandler::class);
        $this->controller = new ContactController(
            $this->domain,
            $this->handler
        );
    }

    private function createRequest()
    {
        return Request::create(
            '/contact',
            'POST',
            [
                'name' => 'Joe Bloggs',
                'email' => 'joe.bloggs@email.com',
                'subject' => 'My Subject',
                'message' => 'My Message',
            ]
        );
    }

    public function testGetFormStartsWithCorrectParams()
    {
        $view = $this->controller->get();
        $data = $view->getData();

        $this->assertEquals($data['title'], 'My Title');
        $this->assertEquals($data['description'], 'My Description');
        $this->assertEquals($data['keywords'], 'One, Two, Three');
        $this->assertEquals($data['author'], 'Author Bloggs');
        $this->assertInstanceOf(ContactCommand::class, $data['command']);
        $this->assertFalse($data['complete']);
        $this->assertEmpty($data['errors']);
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

        $view = $this->controller->post($request);
        $data = $view->getData();

        $this->assertEquals($data['title'], 'My Title');
        $this->assertEquals($data['description'], 'My Description');
        $this->assertEquals($data['keywords'], 'One, Two, Three');
        $this->assertEquals($data['author'], 'Author Bloggs');
        $this->assertInstanceOf(ContactCommand::class, $data['command']);
        $this->assertEquals($data['command']->name, 'Joe Bloggs');
        $this->assertEquals($data['command']->email, 'joe.bloggs@email.com');
        $this->assertEquals($data['command']->subject, 'My Subject');
        $this->assertEquals($data['command']->message, 'My Message');
    }

    public function testValidFormComplete()
    {
        $request = $this->createRequest();

        $this->handler
            ->shouldReceive('handle')
            ->andReturn(true)
            ->once();

        $view = $this->controller->post($request);
        $data = $view->getData();

        $this->assertTrue($data['complete']);
        $this->assertEmpty($data['errors']);
    }

    public function testHoneypotFailurePretendsToBeComplete()
    {
        $request = $this->createRequest();

        $this->handler
            ->shouldReceive('handle')
            ->andThrow(SpamException::class)
            ->once();

        $view = $this->controller->post($request);
        $data = $view->getData();

        $this->assertTrue($data['complete']);
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

        $view = $this->controller->post($request);
        $data = $view->getData();

        $this->assertFalse($data['complete']);
        $this->assertEquals($exception->getErrors(), $data['errors']);
    }
}
