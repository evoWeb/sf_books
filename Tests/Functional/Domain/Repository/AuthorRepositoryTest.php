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

namespace Evoweb\SfBooks\Tests\Functional\Domain\Repository;

use Evoweb\SfBooks\Tests\Functional\AbstractTestBase;
use Evoweb\SfBooks\Domain\Model\Author;
use Evoweb\SfBooks\Domain\Repository\AuthorRepository;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class AuthorRepositoryTest extends AbstractTestBase
{
    private AuthorRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/tx_sfbooks_domain_model_author.csv');

        $this->initializeRequest();
        $this->initializeFrontendTypoScript([
            'plugin.' => [
                'tx_sfbooks.' => [
                    'settings.' => [
                        'fields' => [
                            'selected' => 'username',
                        ],
                    ],
                ],
            ],
        ]);

        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setStoragePageIds([2]);
        $this->subject = GeneralUtility::makeInstance(AuthorRepository::class);
        $this->subject->setDefaultQuerySettings($querySettings);
    }

    #[Test]
    public function findByUidReturnsOneAuthor(): void
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
        $this->assertEquals(
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

    #[Test]
    public function findAuthorGroupedByLetters(): void
    {
        $result = $this->subject->findAuthorGroupedByLetters();
        /** @var Author $author */
        $author = $result['S'][0];
        $properties = [
            'uid' => $author->getUid(),
            'pid' => $author->getPid(),
            'lastname' => $author->getLastname(),
            'firstname' => $author->getFirstname(),
            'description' => $author->getDescription(),
            'capitalLetter' => $author->getCapitalLetter(),
        ];
        $this->assertEquals(
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
