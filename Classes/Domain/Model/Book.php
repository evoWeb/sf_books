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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Book extends AbstractEntity
{
    /**
     * @var ObjectStorage<Author>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $author;

    /**
     * @var ObjectStorage<Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $category;

    /**
     * @var ObjectStorage<Extras>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
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

    /**
     * @var ?Series
     */
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

    public function initializeObject()
    {
        $this->author = new ObjectStorage();
        $this->category = new ObjectStorage();
        $this->extras = new ObjectStorage();
        $this->cover = new ObjectStorage();
        $this->coverLarge = new ObjectStorage();
        $this->samplePdf = new ObjectStorage();
    }

    public function setAuthor(ObjectStorage $author)
    {
        $this->author = $author;
    }

    public function getAuthor(): ObjectStorage
    {
        return $this->author;
    }

    public function setCategory(ObjectStorage $category)
    {
        $this->category = $category;
    }

    public function getCategory(): ObjectStorage
    {
        return $this->category;
    }

    public function setExtras(ObjectStorage $extras)
    {
        $this->extras = $extras;
    }

    public function getExtras(): ObjectStorage
    {
        return $this->extras;
    }

    public function setCover(ObjectStorage $cover)
    {
        $this->cover = $cover;
    }

    public function getCover(): ObjectStorage
    {
        return $this->cover;
    }

    public function setCoverLarge(ObjectStorage $coverLarge)
    {
        $this->coverLarge = $coverLarge;
    }

    public function getCoverLarge(): ObjectStorage
    {
        return $this->coverLarge;
    }

    public function setSamplePdf(ObjectStorage $samplePdf)
    {
        $this->samplePdf = $samplePdf;
    }

    public function getSamplePdf(): ObjectStorage
    {
        return $this->samplePdf;
    }

    public function setSeries(Series $series)
    {
        $this->series = $series;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setYear(string $year)
    {
        $this->year = $year;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function setIsbn(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setLocation1(int $location1)
    {
        $this->location1 = $location1;
    }

    public function getLocation1(): int
    {
        return $this->location1;
    }

    public function setLocation2(int $location2)
    {
        $this->location2 = $location2;
    }

    public function getLocation2(): int
    {
        return $this->location2;
    }

    public function setLocation3(int $location3)
    {
        $this->location3 = $location3;
    }

    public function getLocation3(): int
    {
        return $this->location3;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setSubtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
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
