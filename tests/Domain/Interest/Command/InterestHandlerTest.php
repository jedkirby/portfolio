<?php

namespace App\Tests\Domain\Interest\Command;

use App\Domain\Common\Validation\Exception\ValidationException;
use App\Domain\Interest\Command\InterestCommand;
use App\Domain\Interest\Command\InterestHandler;
use App\Domain\Interest\Command\Validator\InterestValidator;
use App\Domain\Interest\Entity\Interest;
use App\Domain\Interest\Jobs\SendInterestEmail;
use App\Tests\AbstractAppTestCase as TestCase;
use Datetime;
use Mockery;

/**
 * @group domain
 * @group domain.interest
 * @group domain.interest.command
 * @group domain.interest.command.handler
 */
class InterestHandlerTest extends TestCase
{
    private $validator;
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->validator = Mockery::mock(InterestValidator::class);
        $this->handler = new InterestHandler(
            $this->validator
        );
    }

    private function createCommand()
    {
        return new InterestCommand(
            'joe.bloggs@email.com',
            '192.168.1.125',
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

        $this->expectsJobs(SendInterestEmail::class);

        $this->validator
            ->shouldReceive('validate')
            ->with($command)
            ->andReturn([])
            ->once();

        $entity = $this->handler->handle($command);

        $this->assertInstanceOf(Interest::class, $entity);
        $this->assertInstanceOf(Datetime::class, $entity->getDatetime());
        $this->assertSame($entity->getEmail(), $command->email);
        $this->assertSame($entity->getIp(), $command->ip);
        $this->assertSame($entity->getDatetime(), $command->datetime);
    }
}
