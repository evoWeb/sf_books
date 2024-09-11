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

namespace Evoweb\SfBooks\Controller;

use Evoweb\SfBooks\Domain\Model\Author;
use Evoweb\SfBooks\Domain\Repository\AuthorRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorController extends AbstractController
{
    public function __construct(protected AuthorRepository $authorRepository) {}

    protected function initializeAction(): void
    {
        $this->setDefaultOrderings($this->authorRepository);
    }

    protected function listAction(): ResponseInterface
    {
        if ($this->settings['groupAuthors'] ?? false) {
            $authors = $this->authorRepository->findAuthorGroupedByLetters();
        } else {
            $authors = $this->authorRepository->findAll();
        }

        $authors->rewind();
        $this->view->assign('authorGroups', $authors);
        $this->addPaginatorToView($authors);

        return new HtmlResponse($this->view->render());
    }

    protected function showAction(Author $author = null): ResponseInterface
    {
        if ($author == null) {
            $this->displayError('Author');
        }

        $this->setPageTitle($author->getLastname() . ', ' . $author->getFirstname());
        $this->view->assign('author', $author);

        return new HtmlResponse($this->view->render());
    }

    protected function searchAction(string $query, string $searchBy = ''): ResponseInterface
    {
        if (!$searchBy) {
            $searchBy = $this->settings['searchFields'];
        }
        $searchBy = GeneralUtility::trimExplode(',', $searchBy, true);

        $authors = $this->authorRepository->findBySearch($query, $searchBy);

        $this->view->assign('query', $query);
        $this->view->assign('authors', $authors);
        $this->addPaginatorToView($authors);

        return new HtmlResponse($this->view->render());
    }
}
