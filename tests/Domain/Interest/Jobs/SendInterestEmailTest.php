<?php

namespace App\Tests\Domain\Interest\Jobs;

use App\Domain\Interest\Entity\Interest;
use App\Domain\Interest\Jobs\SendInterestEmail;
use App\Tests\AbstractAppTestCase as TestCase;
use Closure;
use Datetime;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mailer\Message;
use Mockery;

/**
 * @group domain
 * @group domain.interest
 * @group domain.interest.jobs
 */
class SendInterestEmailTest extends TestCase
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

    private function createInterestEntity()
    {
        $entity = new Interest();
        $entity->setEmail('joe.bloggs@email.com');
        $entity->setIp('192.168.1.125');
        $entity->setDatetime(
            Datetime::createFromFormat('F j, Y, g:i a', 'February 12, 2017, 6:00 pm')
        );

        return $entity;
    }

    public function testEmailParamsAndHeadersAreCorrect()
    {
        $entity = $this->createInterestEntity();
        $job = new SendInterestEmail($entity);

        $this->mailer
            ->shouldReceive('send')
            ->once()
            ->with(
                'emails.interest',
                Mockery::on(function ($data) use ($entity) {
                    $this->assertSame($data['address'], $entity->getEmail());
                    $this->assertSame($data['ip'], $entity->getIp());
                    $this->assertSame($data['date'], 'February 12, 2017, 6:00 pm');

                    return true;
                }),
                Mockery::on(function (Closure $closure) use ($entity) {
                    $message = Mockery::mock(Message::class);
                    $message->shouldReceive('to')->with('joe.bloggs@email.com', 'Joe Bloggs')->once();
                    $message->shouldReceive('from')->with($entity->getEmail())->once();
                    $message->shouldReceive('subject')->with('Interest')->once();

                    $closure($message);

                    return true;
                })
            );

        $job->handle($this->mailer, $this->config);
    }
}
