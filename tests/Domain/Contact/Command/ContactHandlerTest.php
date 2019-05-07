<?php

namespace App\Tests\Domain\Contact\Command;

use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Contact\Command\ContactCommand;
use App\Domain\Contact\Command\ContactHandler;
use App\Domain\Contact\Command\Validator\ContactValidator;
use App\Domain\Contact\Entity\Contact;
use App\Domain\Contact\Jobs\SendContactEmail;
use App\Tests\AbstractAppTestCase as TestCase;
use Datetime;
use Mockery;

/**
 * @group domain
 * @group domain.contact
 * @group domain.contact.command
 * @group domain.contact.command.handler
 */
class ContactHandlerTest extends TestCase
{
    private $validator;
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->validator = Mockery::mock(ContactValidator::class);
        $this->handler = new ContactHandler(
            $this->validator
        );
    }

    private function createCommand()
    {
        return new ContactCommand(
            'Joe Bloggs',
            'joe.bloggs@email.com',
            'Message Subject',
            'Message Body',
            '192.168.1.125',
            'abc-123',
            ''
        );
    }

    /**
     * @expectedException \App\Domain\Common\Validation\Exception\ValidationException
     */
    public function testThrowsValidationWithErrorsExceptionWhenValidationFails()
    {
        $command = $this->createCommand();

        $this->validator
            ->shouldReceive('validate')
            ->with($command)
            ->andReturn(['name' => 'Error'])
            ->once();

        try {
            $this->handler->handle($command);
        } catch (ValidationException $e) {
            $this->assertSame(['name' => 'Error'], $e->getErrors());
            throw $e;
        }
    }

    public function honeypotValueProvider()
    {
        return [
            ['filled'],
            [' '],
            ['  '],
        ];
    }

    /**
     * @dataProvider honeypotValueProvider
     * @expectedException \App\Domain\Common\Validation\Exception\SpamException
     */
    public function testThrowsSpamExceptionWhenHoneypotIsPopulated($honeypot)
    {
        $command = $this->createCommand();
        $command->honeypot = $honeypot;

        $this->validator
            ->shouldReceive('validate')
            ->with($command)
            ->andReturn([])
            ->once();

        $this->handler->handle($command);
    }

    public function testJobIsDispatchedAndRequestIsReturnedWithTheCorrectData()
    {
        $command = $this->createCommand();

        $this->expectsJobs(SendContactEmail::class);

        $this->validator
            ->shouldReceive('validate')
            ->with($command)
            ->andReturn([])
            ->once();

        $entity = $this->handler->handle($command);

        $this->assertInstanceOf(Contact::class, $entity);
        $this->assertInstanceOf(Datetime::class, $entity->getDatetime());
        $this->assertSame($entity->getName(), $command->name);
        $this->assertSame($entity->getEmail(), $command->email);
        $this->assertSame($entity->getSubject(), $command->subject);
        $this->assertSame($entity->getMessage(), $command->message);
        $this->assertSame($entity->getIp(), $command->ip);
        $this->assertSame($entity->getDatetime(), $command->datetime);
    }
}
