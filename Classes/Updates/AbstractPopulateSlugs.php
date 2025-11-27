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

namespace Evoweb\SfBooks\Updates;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Upgrades\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface;

/**
 * Fills [table].path_segment with a proper value for pages that do not have a slug updater.
 * Does not take "deleted" authors into account but respects workspace records.
 */
abstract class AbstractPopulateSlugs implements UpgradeWizardInterface
{
    protected string $table = '';

    protected string $fieldName = 'path_segment';

    public function __construct(protected ConnectionPool $connectionPool) {}

    abstract public function getTitle(): string;

    abstract public function getDescription(): string;

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    public function updateNecessary(): bool
    {
        return $this->hasRecordsToUpdate();
    }

    public function executeUpdate(): bool
    {
        $connection = $this->connectionPool->getConnectionForTable($this->table);

        $fieldConfig = $GLOBALS['TCA'][$this->table]['columns'][$this->fieldName]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInDb = in_array('unique', $evalInfo, true);
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);

        /** @var SlugHelper $slug */
        $slug = GeneralUtility::makeInstance(SlugHelper::class, $this->table, $this->fieldName, $fieldConfig);

        $records = $this->getRecordsToUpdate();
        while ($recordData = $records->fetchAssociative()) {
            $recordId = (int)$recordData['uid'];
            $pid = (int)$recordData['pid'];

            $proposal = $slug->generate($recordData, $pid);

            $state = RecordStateFactory::forName($this->table)
                ->fromArray($recordData, $pid, $recordId);
            if ($hasToBeUniqueInDb && !$slug->isUniqueInTable($proposal, $state)) {
                $proposal = $slug->buildSlugForUniqueInTable($proposal, $state);
            }
            if ($hasToBeUniqueInSite && !$slug->isUniqueInSite($proposal, $state)) {
                $proposal = $slug->buildSlugForUniqueInSite($proposal, $state);
            }
            if ($hasToBeUniqueInPid && !$slug->isUniqueInPid($proposal, $state)) {
                $proposal = $slug->buildSlugForUniqueInPid($proposal, $state);
            }

            $connection->update(
                $this->table,
                [$this->fieldName => $proposal],
                ['uid' => $recordId]
            );
        }
        return true;
    }

    protected function hasRecordsToUpdate(): bool
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        $expression = $queryBuilder->expr();
        return $queryBuilder
            ->count('uid')
            ->where(
                $expression->or(
                    $expression->eq($this->fieldName, $queryBuilder->quote('')),
                    $expression->isNull($this->fieldName)
                )
            )
            ->executeQuery()
            ->fetchOne() > 0;
    }

    protected function getRecordsToUpdate(): Result
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        $expression = $queryBuilder->expr();
        return $queryBuilder
            ->select('*')
            ->where(
                $expression->or(
                    $expression->eq($this->fieldName, $queryBuilder->quote('')),
                    $expression->isNull($this->fieldName)
                )
            )
            // Ensure that all pages are run through the "per parent page" field and in the correct sorting values
            ->addOrderBy('pid', 'asc')
            ->executeQuery();
    }

    protected function getPreparedQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this
            ->connectionPool
            ->getQueryBuilderForTable($this->table);
        $queryBuilder
            ->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $queryBuilder
            ->from($this->table);

        return $queryBuilder;
    }
}
