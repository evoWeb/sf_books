<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\Controller;

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

use Evoweb\SfBooks\Domain\Model\Book;
use Evoweb\SfBooks\Domain\Repository\BookRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BookController extends AbstractController
{
    protected BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    protected function initializeAction()
    {
        $this->setDefaultOrderings($this->bookRepository);
    }

    protected function initializeListAction()
    {
        $this->settings['category'] = GeneralUtility::intExplode(
            ',',
            $this->settings['category'],
            true
        );
    }

    protected function listAction(): ResponseInterface
    {
        if (
            count($this->settings['category']) == 0
            || (
                count($this->settings['category']) == 1
                && reset($this->settings['category']) < 1
            )
        ) {
            $books = $this->bookRepository->findAll();
        } else {
            $books = $this->bookRepository->findByCategories($this->settings['category']);
        }

        $this->view->assign('books', $books);
        $this->addPaginator($books);

        return new HtmlResponse($this->view->render());
    }

    protected function showAction(Book $book = null): ResponseInterface
    {
        if ($book == null) {
            $this->displayError('Book');
        }

        $this->setPageTitle($book->getTitle());
        $this->view->assign('book', $book);

        return new HtmlResponse($this->view->render());
    }

    protected function searchAction(string $query, string $searchBy = ''): ResponseInterface
    {
        if (!$searchBy) {
            $searchBy = $this->settings['searchFields'];
        }
        $searchBy = GeneralUtility::trimExplode(',', $searchBy, true);

        $books = $this->bookRepository->findBySearch($query, $searchBy);

        $this->view->assign('query', $query);
        $this->view->assign('books', $books);
        $this->addPaginator($books);

        return new HtmlResponse($this->view->render());
    }
}
