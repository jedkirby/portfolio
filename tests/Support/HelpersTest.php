<?php

namespace Test\App\Support;

use Test\App\AbstractTestCase;

class HelpersTest extends AbstractTestCase
{

    /**
     * @test
     * @group support
     * @group support.helpers
     */
    public function itReturnsTheClientVersionInStringFormat()
    {
        $this->assertInternalType(
            'string',
            client_version()
        );
    }

    /**
     * @test
     * @group support
     * @group support.helpers
     * @expectedException App\Support\Exceptions\AssetNotFoundException
     */
    public function itThrowsAnExceptionForUnfoundFile()
    {
        cached_asset('does-not-exist.png');
    }

    /**
     * @test
     * @group support
     * @group support.helpers
     */
    public function itAppendsTheCorrectTimestampToCachedAsset()
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

}
