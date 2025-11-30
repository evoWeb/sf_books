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

namespace Evoweb\SfBooks\Domain\Model;

use TYPO3\CMS\Extbase\Attribute as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Book extends AbstractEntity
{
    /**
     * @var ObjectStorage<Author>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $author;

    /**
     * @var ObjectStorage<Category>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $category;

    /**
     * @var ObjectStorage<Extras>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $extras;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $cover;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $coverLarge;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $samplePdf;

    protected ?Series $series = null;

    protected string $number = '';

    protected string $title = '';

    protected string $subtitle = '';

    protected string $isbn = '';

    protected string $year = '';

    protected string $description = '';

    protected int $location1 = 0;

    protected int $location2 = 0;

    protected int $location3 = 0;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->author = new ObjectStorage();
        $this->category = new ObjectStorage();
        $this->extras = new ObjectStorage();
        $this->cover = new ObjectStorage();
        $this->coverLarge = new ObjectStorage();
        $this->samplePdf = new ObjectStorage();
    }

    /**
     * @param ObjectStorage<Author> $author
     */
    public function setAuthor(ObjectStorage $author): void
    {
        $this->author = $author;
    }

    /**
     * @return ObjectStorage<Author>
     */
    public function getAuthor(): ObjectStorage
    {
        return $this->author;
    }

    /**
     * @param ObjectStorage<Category> $category
     */
    public function setCategory(ObjectStorage $category): void
    {
        $this->category = $category;
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getCategory(): ObjectStorage
    {
        return $this->category;
    }

    /**
     * @param ObjectStorage<Extras> $extras
     */
    public function setExtras(ObjectStorage $extras): void
    {
        $this->extras = $extras;
    }

    /**
     * @return ObjectStorage<Extras>
     */
    public function getExtras(): ObjectStorage
    {
        return $this->extras;
    }

    /**
     * @param ObjectStorage<FileReference> $cover
     */
    public function setCover(ObjectStorage $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getCover(): ObjectStorage
    {
        return $this->cover;
    }

    /**
     * @param ObjectStorage<FileReference> $coverLarge
     */
    public function setCoverLarge(ObjectStorage $coverLarge): void
    {
        $this->coverLarge = $coverLarge;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getCoverLarge(): ObjectStorage
    {
        return $this->coverLarge;
    }

    /**
     * @param ObjectStorage<FileReference> $samplePdf
     */
    public function setSamplePdf(ObjectStorage $samplePdf): void
    {
        $this->samplePdf = $samplePdf;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getSamplePdf(): ObjectStorage
    {
        return $this->samplePdf;
    }

    public function setSeries(Series $series): void
    {
        $this->series = $series;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setLocation1(int $location1): void
    {
        $this->location1 = $location1;
    }

    public function getLocation1(): int
    {
        return $this->location1;
    }

    public function setLocation2(int $location2): void
    {
        $this->location2 = $location2;
    }

    public function getLocation2(): int
    {
        return $this->location2;
    }

    public function setLocation3(int $location3): void
    {
        $this->location3 = $location3;
    }

    public function getLocation3(): int
    {
        return $this->location3;
    }

    public function setNumber(string $number): void
    {
        // @extensionScannerIgnoreLine
        $this->number = $number;
    }

    public function getNumber(): string
    {
        // @extensionScannerIgnoreLine
        return $this->number;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
