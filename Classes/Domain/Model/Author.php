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

namespace Evoweb\SfBooks\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Author extends AbstractEntity
{
    /**
     * @var ObjectStorage<Book>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $books;

    protected string $lastname = '';

    protected string $firstname = '';

    protected string $capitalLetter = '';

    protected string $description = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->books = new ObjectStorage();
    }

    public function setBooks(ObjectStorage $books): void
    {
        $this->books = $books;
    }

    public function getBooks(): ObjectStorage
    {
        return $this->books;
    }

    public function getCapitalLetter(): string
    {
        return strtoupper(substr($this->getLastname(), 0, 1));
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
