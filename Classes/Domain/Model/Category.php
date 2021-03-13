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

class Category extends AbstractEntity
{
    /**
     * @var ObjectStorage<Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $children;

    /**
     * @var ObjectStorage<Book>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $books;

    /**
     * @var ?Category
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?Category $parent = null;

    protected string $title = '';

    protected string $description = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->children = new ObjectStorage();
        $this->books = new ObjectStorage();
    }

    public function setChildren(ObjectStorage $children)
    {
        $this->children = $children;
    }

    public function getChildren(): ObjectStorage
    {
        return $this->children;
    }

    public function setBooks(ObjectStorage $books)
    {
        $this->books = $books;
    }

    public function getBooks(): ObjectStorage
    {
        return $this->books;
    }

    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
