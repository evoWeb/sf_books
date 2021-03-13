<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

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
class Extras extends AbstractEntity
{
    /**
     * @var ?ExtrasLabels
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $label = null;

    protected int $type = 0;

    protected string $content = '';

    public function setLabel(ExtrasLabels $label)
    {
        $this->label = $label;
    }

    public function getLabel(): ?ExtrasLabels
    {
        if ($this->label instanceof LazyLoadingProxy) {
            $this->label = $this->label->_loadRealInstance();
        }
        return $this->label;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
