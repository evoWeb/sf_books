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
     * @var array<non-empty-string>
     */
    protected array $testExtensionsToLoad = ['sf_books'];

    protected ServerRequestInterface $request;

    protected function setUp(): void
    {
        parent::setUp();

        // The Extbase ReflectionService persists its cache in __destruct() at PHP
        // shutdown. The cache is HMAC-signed via HashService, which reads
        // $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']. At shutdown the
        // testing framework has already torn down $GLOBALS['TYPO3_CONF_VARS'],
        // producing "Undefined global variable" warnings. Shutdown functions run
        // before object destructors, so restoring the snapshot taken here keeps the
        // destructor working without a warning.
        $configurationSnapshot = $GLOBALS['TYPO3_CONF_VARS'] ?? null;
        register_shutdown_function(static function () use ($configurationSnapshot): void {
            $GLOBALS['TYPO3_CONF_VARS'] = $configurationSnapshot;
        });
    }

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
