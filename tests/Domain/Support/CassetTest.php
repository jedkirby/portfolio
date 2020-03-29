<?php

namespace App\Tests\Unit\Domain\Support;

use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group domain
 * @group domain.support
 */
class CassetTest extends TestCase
{
    public function testAppendsTheCorrectTimestampToCachedAsset()
    {
        $path = 'assets/tests/img/cached-image.jpg';
        $file = public_path($path);

        $this->assertStringEndsWith(
            '?t=' . filemtime($file),
            casset($path)
        );
    }

    public function testReturnsNormalAssetWhenFileDoesNotExist()
    {
        $path = 'assets/img/tests/does-not-exist.png';

        $this->assertEquals(
            'http://jedkirby.testing/' . $path,
            casset($path)
        );
    }
}
