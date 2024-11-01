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
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Category extends AbstractEntity
{
    /**
     * @var ObjectStorage<Category>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $children;

    /**
     * @var ObjectStorage<Book>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $books;

    #[Extbase\ORM\Lazy]
    protected Category|LazyLoadingProxy|null $parent = null;

    protected string $title = '';

    protected string $description = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->children = new ObjectStorage();
        $this->books = new ObjectStorage();
    }

    public function setChildren(ObjectStorage $children): void
    {
        $this->children = $children;
    }

    public function getChildren(): ObjectStorage
    {
        return $this->children;
    }

    public function setBooks(ObjectStorage $books): void
    {
        $this->books = $books;
    }

    public function getBooks(): ObjectStorage
    {
        return $this->books;
    }

    public function setParent(Category $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
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
