<?php

namespace App\Tests\Domain\Common;

use App\Domain\Common\KeywordGenerator;
use App\Tests\AbstractTestCase as TestCase;

/**
 * @group domain
 * @group domain.common
 * @group domain.common.keyword
 */
class KeywordGeneratorTest extends TestCase
{
    public function testGeneratesStrings()
    {
        $generator = new KeywordGenerator(
            [
                'One',
                'Two',
                'Three',
                'Four',
            ]
        );

        $this->assertEquals(
            $generator->run(),
            'One, Two, Three, Four'
        );
    }

    public function testDefaultLimitApplies()
    {
        $generator = new KeywordGenerator(
            [
                'One',
                'Two',
                'Three',
                'Four',
                'Five',
                'Six',
                'Seven',
                'Eight',
                'Nine',
                'Ten',
                'Eleven',
                'Twelve',
                'Thirteen',
                'Fourteen',
                'Fifteen',
                'Sixteen',
                'Seventeen',
            ]
        );

        $this->assertEquals(
            $generator->run(),
            'One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten, Eleven, Twelve, Thirteen, Fourteen, Fifteen'
        );
    }

    public function testCanOverrideLimit()
    {
        $generator = new KeywordGenerator(
            [
                'One',
                'Two',
                'Three',
                'Four',
                'Five',
            ],
            3
        );

        $this->assertEquals(
            $generator->run(),
            'One, Two, Three'
        );
    }

    public function testNonIntegerLimitReturnsAll()
    {
        $generator = new KeywordGenerator(
            [
                'One',
                'Two',
                'Three',
                'Four',
                'Five',
            ],
            'abc'
        );

        $this->assertEquals(
            $generator->run(),
            'One, Two, Three, Four, Five'
        );
    }

    public function testDuplicatesAreRemoved()
    {
        $generator = new KeywordGenerator(
            [
                'One',
                'Two',
                'Two', // NB: Duplicate
                'Three',
                'Four',
            ]
        );

        $this->assertEquals(
            $generator->run(),
            'One, Two, Three, Four'
        );
    }

    public function testNoKeywordsProvidesEmptyString()
    {
        $generator = new KeywordGenerator();

        $this->assertEquals(
            $generator->run(),
            ''
        );
    }
}
