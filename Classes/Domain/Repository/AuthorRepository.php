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

class AuthorRepository extends Repository
{
    public function findAuthorGroupedByLetters(): array
    {
        $queryBuilder = $this->getQueryBuilderForTable('tx_sfbooks_domain_model_author');
        $statement = $queryBuilder
            ->select('*')
            ->addSelectLiteral('SUBSTR(lastname, 1, 1) AS capital_letter')
            ->from('tx_sfbooks_domain_model_author')
            ->orderBy('lastname')
            ->addOrderBy('firstname')
            ->getSQL();

        /** @var $query \TYPO3\CMS\Extbase\Persistence\Generic\Query */
        $query = $this->createQuery();
        $result = $query->statement($statement)->execute();

        /** @var $author \Evoweb\SfBooks\Domain\Model\Author */
        $groupedAuthors = [];
        foreach ($result as $author) {
            $letter = $author->getCapitalLetter();
            if (!is_array($groupedAuthors[$letter])) {
                $groupedAuthors[$letter] = [];
            }

            $groupedAuthors[$letter][] = $author;
        }

        return $groupedAuthors;
    }

    public function findBySearch(string $searchString, array $searchFields): QueryResultInterface
    {
        $query = $this->createQuery();

        $searchConstrains = [];
        foreach ($searchFields as $field) {
            if ($field === 'firstname' || $field === 'lastname') {
                foreach (\TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $searchString) as $part) {
                    $searchConstrains[] = $query->like($field, '%' . $part . '%');
                }
            } else {
                $searchConstrains[] = $query->like($field, '%' . $searchString . '%');
            }
        }

        $query->matching($query->logicalOr($searchConstrains));

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
