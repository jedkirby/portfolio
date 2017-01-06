<?php

namespace Test\App\Services\Twitter\Connections\Providers;

use GuzzleHttp\Psr7\Response;
use Test\App\AbstractTestCase;
use App\Services\Twitter\Connections\Providers\Guzzle;

class GuzzleConnectionTest extends AbstractTestCase
{

    /**
     * @return Guzzle
     */
    private function getProvider()
    {
        return new Guzzle(null, null, null, null);
    }

    /**
     * @return array
     */
    public function httpCodesProvider()
    {
        return [
            [100, false],
            [201, false]
        ];
    }

    /**
     * @test
     * @group twitter
     * @dataProvider httpCodesProvider
     */
    public function itReturnsCorrectlyForNonOkHttpCodes($statusCode, $expectedReturn)
    {

        $provider = $this->getProvider();
        $response = $this->getMockBuilder(Response::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $decodedResponse = $provider->decodeResponse($response);

        $this->assertEquals(
            $decodedResponse,
            $expectedReturn
        );

    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsCorrectlyForOkHttpCodes()
    {

        $body = ['one', 'two'];

        $provider = $this->getProvider();
        $response = $this->getMockBuilder(Response::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(200);

        $response
            ->method('getBody')
            ->willReturn(json_encode($body));

        $decodedResponse = $provider->decodeResponse($response);

        $this->assertInternalType(
            'array',
            $decodedResponse
        );

        $this->assertEquals(
            $decodedResponse,
            $body
        );

    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsFalseForNoneArrayOkResponse()
    {

        $provider = $this->getProvider();
        $response = $this->getMockBuilder(Response::class)->getMock();

        $response
            ->method('getStatusCode')
            ->willReturn(200);

        $response
            ->method('getBody')
            ->willReturn('');

        $decodedResponse = $provider->decodeResponse($response);

        $this->assertFalse($decodedResponse);

    }

}
