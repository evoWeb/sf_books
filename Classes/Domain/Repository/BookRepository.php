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

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BookRepository extends Repository
{
    public function findByCategories(array $categories): QueryResultInterface
    {
        $query = $this->createQuery();

        $categoryConstraints = [];
        foreach ($categories as $category) {
            $categoryConstraints[] = $query->contains('category', $category);
        }
        $constraint = $query->logicalOr(...$categoryConstraints);

        $query->matching($constraint);

        return $query->execute();
    }

    public function findBySearch(string $searchString, array $searchFields): QueryResultInterface
    {
        $query = $this->createQuery();

        $searchConstrains = [];
        foreach ($searchFields as $field) {
            $searchConstrains[] = $query->like($field, '%' . $searchString . '%');
        }

        $query->matching($query->logicalOr(...$searchConstrains));

        return $query->execute();
    }
}
