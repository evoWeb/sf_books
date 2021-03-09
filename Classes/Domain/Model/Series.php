<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Series extends AbstractEntity
{
    /**
     * @var ObjectStorage<Book>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $books;

    protected string $title = '';

    protected string $capitalLetter = '';

    protected string $info = '';

    protected string $description = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->books = new ObjectStorage();
    }

    public function setBooks(ObjectStorage $books)
    {
        $this->books = $books;
    }

    public function getBooks(): ObjectStorage
    {
        return $this->books;
    }

    public function getCapitalLetter(): string
    {
        return strtoupper($this->capitalLetter);
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setInfo(string $info)
    {
        $this->info = $info;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
