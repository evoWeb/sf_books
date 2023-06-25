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

namespace Evoweb\SfBooks\Domain\Repository;

use Evoweb\SfBooks\Domain\Model\Series;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class SeriesRepository extends Repository
{
    protected ConnectionPool $connectionPool;

    public function __construct(PersistenceManagerInterface $persistenceManager, ConnectionPool $connectionPool)
    {
        $this->persistenceManager = $persistenceManager;
        $this->connectionPool = $connectionPool;
        parent::__construct();
    }

    public function findSeriesGroupedByLetters(): array
    {
        $queryBuilder = $this->getQueryBuilderForTable('tx_sfbooks_domain_model_series');
        $statement = $queryBuilder
            ->select('*')
            ->from('tx_sfbooks_domain_model_series')
            ->orderBy('title')
            ->getSQL();

        /** @var Query $query */
        $query = $this->createQuery();
        $result = $query->statement($statement)->execute();

        $groupedSeries = [];
        /** @var Series $series */
        foreach ($result as $series) {
            $letter = $series->getCapitalLetter();
            if (!isset($groupedSeries[$letter]) || !is_array($groupedSeries[$letter])) {
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
        $constraint = $query->logicalOr(...$seriesConstraints);

        $query->matching($constraint);

        return $query->execute();
    }

    protected function getQueryBuilderForTable(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
