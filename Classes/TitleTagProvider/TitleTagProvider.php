<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\TitleTagProvider;

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

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class TitleTagProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
