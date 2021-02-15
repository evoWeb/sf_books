<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\Domain\Repository;

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

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class SeriesRepository extends Repository
{
    public function findSeriesGroupedByLetters(): array
    {
        $queryBuilder = $this->getQueryBuilderForTable('tx_sfbooks_domain_model_series');
        $statement = $queryBuilder
            ->select('*')
            ->addSelectLiteral('SUBSTR(title, 1, 1) AS capital_letter')
            ->from('tx_sfbooks_domain_model_series')
            ->orderBy('title')
            ->getSQL();

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Query $query */
        $query = $this->createQuery();
        $result = $query->statement($statement)->execute();

        /** @var \Evoweb\SfBooks\Domain\Model\Series $series */
        $groupedSeries = [];
        foreach ($result as $series) {
            $letter = $series->getCapitalLetter();
            if (!is_array($groupedSeries[$letter])) {
                $groupedSeries[$letter] = [];
            }

            $groupedSeries[$letter][] = $series;
        }

        return $groupedSeries;
    }

    public function findBySeries(array $series): QueryResultInterface
    {
        $query = $this->createQuery();

        $seriesConstraints = [];
        foreach ($series as $serie) {
            $seriesConstraints[] = $query->equals('uid', $serie);
        }
        $constraint = $query->logicalOr($seriesConstraints);

        $query->matching($constraint);

        return $query->execute();
    }

    protected function getQueryBuilderForTable(string $table): \TYPO3\CMS\Core\Database\Query\QueryBuilder
    {
        /** @var \TYPO3\CMS\Core\Database\ConnectionPool $pool */
        $pool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Database\ConnectionPool::class
        );
        return $pool->getQueryBuilderForTable($table);
    }
}
