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
class SeriesRepositoryTest extends \Evoweb\SfBooks\Tests\Functional\AbstractTestCase
{
    /**
     * @var \Evoweb\SfBooks\Domain\Repository\SeriesRepository
     */
    private $subject;

    /**
     * Sets up this test suite.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(ORIGINAL_ROOT . $this->fixturePath . 'tx_sfbooks_domain_model_series.xml');

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
        $this->subject = $objectManager->get(\Evoweb\SfBooks\Domain\Repository\SeriesRepository::class);
    }

    /**
     * @test
     */
    public function findByUidReturnsOneSeries()
    {
        $series = $this->subject->findByUid(1);
        $properties = [
            'uid' => $series->getUid(),
            'pid' => $series->getPid(),
            'title' => $series->getTitle(),
            'info' => $series->getInfo(),
            'description' => $series->getDescription(),
            'capitalLetter' => $series->getCapitalLetter(),
        ];
        unset($properties['books']);
        self::assertEquals(
            [
                'uid' => 1,
                'pid' => 2,
                'title' => 'Silberbände',
                'info' => 'Info',
                'description' => 'Test description',
                'capitalLetter' => 'S',
            ],
            $properties
        );
    }

    /**
     * @test
     */
    public function findSeriesGroupedByLetters()
    {
        $response = $this->subject->findSeriesGroupedByLetters();
        /** @var \Evoweb\SfBooks\Domain\Model\Series $series */
        $series = $response['S'][0];
        $properties = [
            'uid' => $series->getUid(),
            'pid' => $series->getPid(),
            'title' => $series->getTitle(),
            'info' => $series->getInfo(),
            'description' => $series->getDescription(),
            'capitalLetter' => $series->getCapitalLetter(),
        ];
        unset($properties['books']);
        self::assertEquals(
            [
                'uid' => 1,
                'pid' => 2,
                'title' => 'Silberbände',
                'info' => 'Info',
                'description' => 'Test description',
                'capitalLetter' => 'S',
            ],
            $properties
        );
    }
}
