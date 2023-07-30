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

use Evoweb\SfBooks\Domain\Model\Series;
use Evoweb\SfBooks\Domain\Repository\SeriesRepository;
use Evoweb\SfBooks\Tests\Functional\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class SeriesRepositoryTest extends AbstractTestCase
{
    private SeriesRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setStoragePageIds([2]);
        $this->subject = GeneralUtility::makeInstance(SeriesRepository::class);
        $this->subject->setDefaultQuerySettings($querySettings);

        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/tx_sfbooks_domain_model_series.csv');
    }

    #[Test]
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

    #[Test]
    public function findSeriesGroupedByLetters()
    {
        $result = $this->subject->findSeriesGroupedByLetters();
        /** @var Series $series */
        $series = $result['S'][0];
        $properties = [
            'uid' => $series->getUid(),
            'pid' => $series->getPid(),
            'title' => $series->getTitle(),
            'info' => $series->getInfo(),
            'description' => $series->getDescription(),
            'capitalLetter' => $series->getCapitalLetter(),
        ];
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
