<?php

declare(strict_types=1);

/*
 * This file is copied from the TYPO3 CMS install tool package.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Evoweb\SfBooks\Updates;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Fills [table].path_segment with a proper value for pages that do not have a slug updater.
 * Does not take "deleted" authors into account, but respects workspace records.
 */
abstract class AbstractPopulateSlugs implements UpgradeWizardInterface
{
    protected string $table = 'tx_sfbooks_domain_model_author';

    protected string $fieldName = 'path_segment';

    public function __construct(protected ConnectionPool $connectionPool) {
    }

    abstract public function getTitle(): string;

    abstract public function getDescription(): string;

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
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
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        /** @var SlugHelper $slugHelper */
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $this->table, $this->fieldName, $fieldConfig);

        $statement = $this->getRecordsToUpdate();
        while ($record = $statement->fetchAssociative()) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];

            $slug = $slugHelper->generate($record, $pid);

            $state = RecordStateFactory::forName($this->table)
                ->fromArray($record, $pid, $recordId);
            if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
            }
            if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
            }

            $connection->update(
                $this->table,
                [$this->fieldName => $slug],
                ['uid' => $recordId]
            );
        }
        return true;
    }

    protected function hasRecordsToUpdate(): bool
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        return (bool)$queryBuilder
            ->count('uid')
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq($this->fieldName, $queryBuilder->quote('')),
                    $queryBuilder->expr()->isNull($this->fieldName)
                )
            )
            ->executeQuery()
            ->fetchOne();
    }

    protected function getRecordsToUpdate(): Result
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        return $queryBuilder
            ->select('*')
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq($this->fieldName, $queryBuilder->quote('')),
                    $queryBuilder->expr()->isNull($this->fieldName)
                )
            )
            // Ensure that all pages are run through "per parent page" field, and in the correct sorting values
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
