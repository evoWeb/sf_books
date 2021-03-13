<?php

namespace Evoweb\SfBooks\Tests\Functional;

/**
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Functional test for the DataHandler
 */
abstract class AbstractTestCase extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/sf_books',
    ];

    /**
     * @var int
     */
    protected $expectedLogEntries = 0;

    /**
     * @var string
     */
    protected $backendUserFixture = 'typo3conf/ext/sf_books/Tests/Functional/Fixtures/be_users.xml';

    /**
     * @var string
     */
    protected $fixturePath = 'typo3conf/ext/sf_books/Tests/Functional/Fixtures/';

    /**
     * Sets up this test suite.
     */
    protected function setUp(): void
    {
        parent::setUp();
        \TYPO3\CMS\Core\Core\Bootstrap::initializeLanguageObject();
    }

    /**
     * Tears down this test case.
     */
    protected function tearDown(): void
    {
        $this->assertNoLogEntries();
    }

    /**
     * Assert that no sys_log entries had been written.
     */
    protected function assertNoLogEntries()
    {
        $logEntries = $this->getLogEntries();

        if (count($logEntries) > $this->expectedLogEntries) {
            var_dump(array_values($logEntries));
            ob_flush();
            self::fail('The sys_log table contains unexpected entries.');
        } elseif (count($logEntries) < $this->expectedLogEntries) {
            self::fail('Expected count of sys_log entries no reached.');
        }
    }

    /**
     * Gets log entries from the sys_log
     *
     * @return array
     */
    protected function getLogEntries()
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
            ->execute()
            ->fetchAll();
        return $result;
    }
}
