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
class AuthorRepositoryTest extends \Evoweb\SfBooks\Tests\Functional\AbstractTestCase
{
    /**
     * @var \Evoweb\SfBooks\Domain\Repository\AuthorRepository
     */
    private $subject;

    /**
     * Sets up this test suite.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(ORIGINAL_ROOT . $this->fixturePath . 'tx_sfbooks_domain_model_author.xml');

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
        $this->subject = $objectManager->get(\Evoweb\SfBooks\Domain\Repository\AuthorRepository::class);
    }

    /**
     * @test
     */
    public function findByUidReturnsOneAuthor()
    {
        $response = $this->subject->findByUid(1);
        $properties = $response->_getProperties();
        unset($properties['books']);
        self::assertEquals(
            [
                'uid' => 1,
                'pid' => 2,
                'lastname' => 'Shelley',
                'firstname' => 'Mary',
                'description' => 'Test description',
                'capitalLetter' => null,
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
        /** @var \Evoweb\SfBooks\Domain\Model\Author $author */
        $author = $response['S'][0];
        $properties = $author->_getProperties();
        unset($properties['books']);
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
