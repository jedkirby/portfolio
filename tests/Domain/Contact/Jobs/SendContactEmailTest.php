<?php

namespace App\Tests\Domain\Contact\Jobs;

use App\Domain\Contact\Entity\Contact;
use App\Domain\Contact\Jobs\SendContactEmail;
use App\Tests\AbstractTestCase as TestCase;
use Closure;
use Datetime;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mailer\Message;
use Mockery;

/**
 * @group domain
 * @group domain.contact
 * @group domain.contact.jobs
 */
class SendContactEmailTest extends TestCase
{
    private $config;
    private $defaults = [
        'site.meta.author' => 'Joe Bloggs',
        'site.meta.email.to' => 'joe.bloggs@email.com',
    ];

    public function setUp()
    {
        $config = Mockery::mock(Config::class);

        foreach ($this->defaults as $key => $value) {
            $config
                ->shouldReceive('get')
                ->with($key)
                ->andReturn($value)
                ->once();
        }

        $this->config = $config;
        $this->mailer = Mockery::mock(Mailer::class);
    }

    private function createContactEntity()
    {
        $entity = new Contact();
        $entity->setName('Joe Bloggs');
        $entity->setEmail('joe.bloggs@email.com');
        $entity->setSubject('Message Subject');
        $entity->setMessage('Message Body');
        $entity->setIp('192.168.1.125');
        $entity->setDatetime(
            Datetime::createFromFormat('F j, Y, g:i a', 'February 12, 2017, 6:00 pm')
        );

        return $entity;
    }

    public function testEmailParamsAndHeadersAreCorrect()
    {
        $entity = $this->createContactEntity();
        $job = new SendContactEmail($entity);

        $this->mailer
            ->shouldReceive('send')
            ->once()
            ->with(
                'emails.contact',
                Mockery::on(function ($data) use ($entity) {
                    $this->assertSame($data['name'], $entity->getName());
                    $this->assertSame($data['address'], $entity->getEmail());
                    $this->assertSame($data['ip'], $entity->getIp());
                    $this->assertSame($data['content'], $entity->getMessage());
                    $this->assertSame($data['date'], 'February 12, 2017, 6:00 pm');

                    return true;
                }),
                Mockery::on(function (Closure $closure) use ($entity) {
                    $message = Mockery::mock(Message::class);
                    $message->shouldReceive('to')->with('joe.bloggs@email.com', 'Joe Bloggs')->once();
                    $message->shouldReceive('from')->with($entity->getEmail(), $entity->getName())->once();
                    $message->shouldReceive('subject')->with($entity->getSubject())->once();

                    $closure($message);

                    return true;
                })
            );

        $job->handle($this->mailer, $this->config);
    }
}
