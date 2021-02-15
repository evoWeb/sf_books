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

class CategoryRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
    ];

    public function findByCategories(array $categories): QueryResultInterface
    {
        $query = $this->createQuery();

        $categoryConstraints = [];
        foreach ($categories as $category) {
            $categoryConstraints[] = $query->equals('uid', $category);
        }
        $constraint = $query->logicalOr($categoryConstraints);

        $query->matching($constraint);

        return $query->execute();
    }
}
