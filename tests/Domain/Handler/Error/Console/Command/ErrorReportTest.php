<?php

namespace App\Tests\Domain\Handler\Error\Console\Command;

use App\Domain\Handler\Error\Console\Command\ErrorReport;
use App\Tests\AbstractTestCase as TestCase;

/**
 * @group domain
 * @group domain.handler
 * @group domain.handler.error
 * @group domain.handler.error.console
 * @group domain.handler.error.console.command
 * @group domain.handler.error.console.command.errors
 */
class ErrorReportTest extends TestCase
{
    public function testNotCompletedYet()
    {
        (new ErrorReport())->fire();
    }
}
