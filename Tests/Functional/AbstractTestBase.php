<?php

declare(strict_types=1);

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

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequestFactory;
use TYPO3\CMS\Core\TypoScript\AST\Node\RootNode;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

abstract class AbstractTestBase extends FunctionalTestCase
{
    /**
     * @var array<string, array<string, string|int>>
     */
    protected const LANGUAGE_PRESETS = [
        'EN' => [
            'id' => 0,
            'title' => 'English',
            'locale' => 'en_US.UTF8',
        ],
    ];

    protected array $coreExtensionsToLoad = ['install'];

    /**
     * Use a NullBackend for the extbase (reflection) cache. Otherwise the
     * ReflectionService persists its cache in __destruct() at PHP shutdown,
     * where $GLOBALS['TYPO3_CONF_VARS'] is already torn down by the testing
     * framework, triggering HashService warnings about a missing encryptionKey.
     *
     * @var array<string, mixed>
     */
    protected array $configurationToUseInTestInstance = [
        'SYS' => [
            'caching' => [
                'cacheConfigurations' => [
                    'extbase' => [
                        'backend' => NullBackend::class,
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var array<non-empty-string>
     */
    protected array $testExtensionsToLoad = ['sf_books'];

    protected ServerRequestInterface $request;

    public function initializeRequest(): void
    {
        $serverRequestFactory = new ServerRequestFactory();
        $this->request = $serverRequestFactory
            ->createServerRequest('GET', '/')
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE);
        $GLOBALS['TYPO3_REQUEST'] = $this->request;
    }

    /**
     * @param array<string, mixed> $setup
     * @param array<string, mixed> $config
     */
    public function initializeFrontendTypoScript(array $setup = [], array $config = []): void
    {
        $frontendTypoScript = new FrontendTypoScript(new RootNode(), [], [], []);
        $frontendTypoScript->setSetupArray($setup);
        $frontendTypoScript->setConfigArray($config);
        $this->request = $this->request->withAttribute('frontend.typoscript', $frontendTypoScript);
        $GLOBALS['TYPO3_REQUEST'] = $this->request;
    }
}
