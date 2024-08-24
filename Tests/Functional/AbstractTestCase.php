<?php

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Evoweb\SfBooks\Tests\Functional;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Abstract functional test for the repositories
 */
abstract class AbstractTestCase extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['sf_books'];

    protected int $expectedLogEntries = 0;

    protected function tearDown(): void
    {
        $this->assertNoLogEntries();
    }

    /**
     * Assert that no sys_log entries had been written.
     */
    protected function assertNoLogEntries(): void
    {
        $logEntries = $this->getLogEntries();

        if (count($logEntries) > $this->expectedLogEntries) {
            var_dump(array_values($logEntries));
            ob_flush();
            self::fail('The sys_log table contains unexpected entries.');
        } elseif (count($logEntries) < $this->expectedLogEntries) {
            self::fail('Expected count of sys_log entries not reached.');
        }
    }

    protected function getLogEntries(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_log');
        $result = $queryBuilder
            ->select('*')
            ->from('sys_log')
            ->where(
                $queryBuilder->expr()->in(
                    'error',
                    [1, 2]
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
        return is_array($result) ? $result : [];
    }
}
