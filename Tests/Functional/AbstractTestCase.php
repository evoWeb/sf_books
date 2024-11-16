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

use Doctrine\DBAL\Exception;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Abstract functional test for the repositories
 */
abstract class AbstractTestCase extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['sf_books'];

    protected int $expectedLogEntries = 0;


    protected function setUp(): void
    {
        parent::setUp();

        $request = $this->createServerRequest('https://typo3-testing.local/typo3/');
        $GLOBALS['TYPO3_REQUEST'] = $request;
    }

    private function createServerRequest(string $url): ServerRequestInterface
    {
        $requestUrlParts = parse_url($url);
        $docRoot = $this->instancePath;

        $serverParams = [
            'DOCUMENT_ROOT' => $docRoot,
            'HTTP_USER_AGENT' => 'TYPO3 Functional Test Request',
            'HTTP_HOST' => $requestUrlParts['host'] ?? 'localhost',
            'SERVER_NAME' => $requestUrlParts['host'] ?? 'localhost',
            'SERVER_ADDR' => '127.0.0.1',
            'REMOTE_ADDR' => '127.0.0.1',
            'SCRIPT_NAME' => '/index.php',
            'PHP_SELF' => '/index.php',
            'SCRIPT_FILENAME' => $docRoot . '/index.php',
            'PATH_TRANSLATED' => $docRoot . '/index.php',
            'QUERY_STRING' => $requestUrlParts['query'] ?? '',
            'REQUEST_URI' => $requestUrlParts['path'] . (isset($requestUrlParts['query']) ? '?' . $requestUrlParts['query'] : ''),
            'REQUEST_METHOD' => 'GET',
        ];
        // Define HTTPS and server port
        if (isset($requestUrlParts['scheme'])) {
            if ($requestUrlParts['scheme'] === 'https') {
                $serverParams['HTTPS'] = 'on';
                $serverParams['SERVER_PORT'] = '443';
            } else {
                $serverParams['SERVER_PORT'] = '80';
            }
        }

        // Define a port if used in the URL
        if (isset($requestUrlParts['port'])) {
            $serverParams['SERVER_PORT'] = $requestUrlParts['port'];
        }
        // set up normalizedParams
        $request = new ServerRequest($url, 'GET', null, [], $serverParams);
        $request = $request->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE);
        return $request->withAttribute('normalizedParams', NormalizedParams::createFromRequest($request));
    }

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

    /**
     * @return array<array<string, mixed>>
     */
    protected function getLogEntries(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_log');
        $result = $queryBuilder
            ->select('*')
            ->from('sys_log')
            ->where(
                $queryBuilder->expr()->in(
                    'error',
                    [1, 2]
                )
            )
            ->executeQuery();
        try {
            $result = $result->fetchAllAssociative();
        } catch (Exception) {
        }
        return is_array($result) ? $result : [];
    }
}
