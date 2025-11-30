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

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Attribute\UpgradeWizard;

/**
 * Fills tx_sfbooks_domain_model_book.path_segment with a proper value for pages that do not have a slug updater.
 * Does not take "deleted" books into account but respects workspace records.
 */
#[Autoconfigure(public: true)]
#[UpgradeWizard('sfBooksBooksSlugs')]
class PopulateBookSlugs extends AbstractPopulateSlugs
{
    protected string $table = 'tx_sfbooks_domain_model_book';

    /**
     * Title of this updater
     */
    public function getTitle(): string
    {
        return 'Introduce URL parts ("slugs") to all existing books';
    }

    /**
     * Longer description of this updater
     */
    public function getDescription(): string
    {
        return 'TYPO3 includes native URL handling. Every book record has its own speaking URL path'
            . ' called "path_segment" which can be edited in TYPO3 Backend. However, it is necessary'
            . ' that all books have a URL pre-filled. This is done by evaluating the book title / subtitle.';
    }
}
