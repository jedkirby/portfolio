<?php

namespace App\Tests\Domain\Interest\Command\Validator;

use App\Domain\Interest\Command\InterestCommand;
use App\Domain\Interest\Command\Validator\InterestValidator;
use App\Tests\AbstractTestCase as TestCase;
use Illuminate\Validation\Factory as Validator;
use Symfony\Component\Translation\Translator;

/**
 * @group domain
 * @group domain.interest
 * @group domain.interest.command
 * @group domain.interest.command.validator
 */
class InterestValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new InterestValidator(
            new Validator(
                new Translator('en-gb')
            )
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

    public function testValidCommand()
    {
        $command = $this->createCommand();

        $this->assertEmpty($this->validator->validate($command));
    }

    public function testRequiredField()
    {
        $command = $this->createCommand();
        $command->email = '';

        $this->assertArrayHasKey('email', $this->validator->validate($command));
    }

    public function invalidEmailAddressProvider()
    {
        return [
            ['plainaddress'],
            ['#@%^%#$@#$@#.com'],
            ['@example.com'],
            ['Joe Smith <email@example.com>'],
            ['email.example.com'],
            ['email@example@example.com'],
            ['.email@example.com'],
            ['email.@example.com'],
            ['email..email@example.com'],
            ['あいうえお@example.com'],
            ['email@example.com (Joe Smith)'],
            ['email@example'],
            ['email@-example.com'],
            ['email@111.222.333.44444'],
            ['email@example..com'],
            ['Abc..123@example.com'],
        ];
    }

    /**
     * @dataProvider invalidEmailAddressProvider
     */
    public function testEmailValidity($email)
    {
        $command = $this->createCommand();
        $command->email = $email;

        $this->assertArrayHasKey('email', $this->validator->validate($command));
    }
}
