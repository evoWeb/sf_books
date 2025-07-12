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

use Evoweb\SfBooks\Domain\Model\Author;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Exception;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * A repository for authors
 *
 * @extends Repository<Author>
 */
class AuthorRepository extends Repository
{
    public function __construct(
        protected ConnectionPool $connectionPool,
        PersistenceManagerInterface $persistenceManager
    ) {
        $this->persistenceManager = $persistenceManager;
        parent::__construct();
    }

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    public function findAuthorGroupedByLetters(): array
    {
        /** @var Query<Author> $query */
        $query = $this->createQuery();

        $queryBuilder = $this->getQueryBuilderForTable('tx_sfbooks_domain_model_author');
        $queryBuilder
            ->select('*')
            ->from('tx_sfbooks_domain_model_author');

        $storagePageIds = $query->getQuerySettings()->getStoragePageIds();
        if (count($storagePageIds) && $query->getQuerySettings()->getRespectStoragePage()) {
            $queryBuilder->where($queryBuilder->expr()->in('pid', $storagePageIds));
        }

        foreach ($query->getOrderings() as $fieldName => $direction) {
            $queryBuilder->addOrderBy($fieldName, $direction);
        }

        $result = $query->statement($queryBuilder)->execute();

        $groupedAuthors = [];
        /** @var Author $author */
        foreach ($result as $author) {
            $letter = $author->getCapitalLetter();
            if (!is_array($groupedAuthors[$letter] ?? '')) {
                $groupedAuthors[$letter] = [];
            }

            $groupedAuthors[$letter][] = $author;
        }

        return $groupedAuthors;
    }

    /**
     * @param string[] $searchFields
     * @return QueryResultInterface<int, Author>
     * @throws InvalidQueryException
     */
    public function findBySearch(string $searchString, array $searchFields): QueryResultInterface
    {
        $query = $this->createQuery();

        $searchConstrains = [];
        foreach ($searchFields as $field) {
            if ($field === 'firstname' || $field === 'lastname') {
                foreach (GeneralUtility::trimExplode(' ', $searchString, true) as $part) {
                    $searchConstrains[] = $query->like($field, '%' . $part . '%');
                }
            } else {
                $searchConstrains[] = $query->like($field, '%' . $searchString . '%');
            }
        }

        $query->matching($query->logicalOr(...$searchConstrains));

        return $query->execute();
    }

    protected function getQueryBuilderForTable(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
