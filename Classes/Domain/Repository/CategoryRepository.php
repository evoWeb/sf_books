<?php

declare(strict_types=1);

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Evoweb\SfBooks\Domain\Repository;

use Evoweb\SfBooks\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * A repository for categories
 *
 * @extends Repository<Category>
 */
class CategoryRepository extends Repository
{
    /**
     * @param int[] $categories
     * @return QueryResultInterface<int, Category>
     * @throws InvalidQueryException
     */
    public function findByUids(array $categories): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->in('uid', $categories));
        return $query->execute();
    }
}
