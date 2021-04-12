<?php

declare(strict_types=1);

namespace ErrorTest\Service;

use Error\Service\FileErrorLogger;
use PHPUnit\Framework\TestCase;

class FileErrorLoggerTest extends TestCase
{
    private const TEST_LOG_FILE_PATH = __DIR__ . '/../TestHelper/Log/test_error.log';

    public function testCanSaveLogIntoFile(): void
    {
        $testLog = 'Test Log Message';

        $logger = new FileErrorLogger(self::TEST_LOG_FILE_PATH);
        $logger->log($testLog);

        $logsContent = file_get_contents(self::TEST_LOG_FILE_PATH);

        $this->assertTrue(str_contains($logsContent, $testLog));
    }

    public function tearDown(): void
    {
        unlink(self::TEST_LOG_FILE_PATH);
    }
}
