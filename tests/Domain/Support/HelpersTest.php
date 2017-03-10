<?php

namespace App\Tests\Domain\Support;

use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group support
 * @group support.helpers
 */
class HelpersTest extends TestCase
{
    public function testReturnsTheClientVersionInStringFormat()
    {
        $this->assertInternalType(
            'string',
            client_version()
        );
    }

    public function testAppendsTheCorrectTimestampToCachedAsset()
    {
        $asset = 'assets/img/logo.svg';
        $assetCached = cached_asset($asset);

        $filemtime = filemtime(
            public_path($asset)
        );

        $this->assertTrue(
            ends_with($assetCached, $filemtime)
        );
    }

    /**
     * @expectedException \App\Domain\Support\Exception\AssetNotFoundException
     */
    public function testThrowsAnExceptionForUnfoundFile()
    {
        cached_asset('does-not-exist.png');
    }
}
