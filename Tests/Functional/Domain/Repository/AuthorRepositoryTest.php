<?php

namespace Evoweb\SfBooks\Tests\Functional\Domain\Repository;

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

use Evoweb\SfBooks\Domain\Model\Author;
use Evoweb\SfBooks\Domain\Repository\AuthorRepository;
use Evoweb\SfBooks\Tests\Functional\AbstractTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorRepositoryTest extends AbstractTestCase
{
    /**
     * @var AuthorRepository
     */
    private $subject;

    /**
     * Sets up this test suite.
     */
    protected function setUp(): void
    {
        $GLOBALS['PAGES_TYPES']['default']['allowedTables'] = '';

        parent::setUp();

        $this->subject = GeneralUtility::makeInstance(AuthorRepository::class);

        $this->importDataSet(__DIR__ . '/../../Fixtures/tx_sfbooks_domain_model_author.xml');
    }

    /**
     * @test
     */
    public function findByUidReturnsOneAuthor()
    {
        $author = $this->subject->findByUid(1);
        $properties = [
            'uid' => $author->getUid(),
            'pid' => $author->getPid(),
            'lastname' => $author->getLastname(),
            'firstname' => $author->getFirstname(),
            'description' => $author->getDescription(),
            'capitalLetter' => $author->getCapitalLetter(),
        ];
        self::assertEquals(
            [
                'uid' => 1,
                'pid' => 2,
                'lastname' => 'Shelley',
                'firstname' => 'Mary',
                'description' => 'Test description',
                'capitalLetter' => 'S',
            ],
            $properties
        );
    }

    /**
     * @test
     */
    public function findAuthorGroupedByLetters()
    {
        $response = $this->subject->findAuthorGroupedByLetters();
        /** @var Author $author */
        $author = $response['S'][0];
        $properties = [
            'uid' => $author->getUid(),
            'pid' => $author->getPid(),
            'lastname' => $author->getLastname(),
            'firstname' => $author->getFirstname(),
            'description' => $author->getDescription(),
            'capitalLetter' => $author->getCapitalLetter(),
        ];
        self::assertEquals(
            [
                'uid' => 1,
                'pid' => 2,
                'lastname' => 'Shelley',
                'firstname' => 'Mary',
                'description' => 'Test description',
                'capitalLetter' => 'S',
            ],
            $properties
        );
    }
}
