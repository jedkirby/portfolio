<?php

namespace App\Tests\Unit\Domain\Support;

use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group domain
 * @group domain.support
 */
class ClientVersionTest extends TestCase
{
    public function testReturnsTheClientVersionInStringFormat()
    {
        $this->assertInternalType(
            'string',
            client_version()
        );
    }
}
