<?php

namespace App\Tests\Domain\Contact\Command\Validator;

use App\Domain\Contact\Command\ContactCommand;
use App\Domain\Contact\Command\Validator\ContactValidator;
use App\Tests\AbstractTestCase as TestCase;
use Illuminate\Validation\Factory as Validator;
use Symfony\Component\Translation\Translator;

/**
 * @group domain
 * @group domain.contact
 * @group domain.contact.command
 * @group domain.contact.command.validator
 */
class ContactValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new ContactValidator(
            new Validator(
                new Translator('en-gb')
            )
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
            ''
        );
    }

    public function testValidCommand()
    {
        $command = $this->createCommand();

        $this->assertEmpty($this->validator->validate($command));
    }

    public function requiredFieldsProvider()
    {
        return [
            ['name'],
            ['email'],
            ['message'],
        ];
    }

    /**
     * @dataProvider requiredFieldsProvider
     */
    public function testRequiredFields($field)
    {
        $command = $this->createCommand();
        $command->$field = '';

        $this->assertArrayHasKey($field, $this->validator->validate($command));
    }

    public function testSubjectNotRequired()
    {
        $command = $this->createCommand();
        $command->subject = '';

        $this->assertArrayNotHasKey('subject', $this->validator->validate($command));
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
