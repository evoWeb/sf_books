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
use Evoweb\SfBooks\Domain\Model\Book;
use Evoweb\SfBooks\Domain\Model\Category;
use Evoweb\SfBooks\Domain\Model\Series;
use Evoweb\SfBooks\Domain\Repository\AuthorRepository;
use Evoweb\SfBooks\Domain\Repository\BookRepository;
use Evoweb\SfBooks\Domain\Repository\CategoryRepository;
use Evoweb\SfBooks\Domain\Repository\SeriesRepository;
use Evoweb\SfBooks\TitleTagProvider\TitleTagProvider;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ImmediateResponseException;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\PaginationInterface;
use TYPO3\CMS\Core\Pagination\PaginatorInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use TYPO3Fluid\Fluid\View\ViewInterface;

abstract class AbstractController extends ActionController
{
    protected function setDefaultOrderings(
        AuthorRepository|BookRepository|CategoryRepository|SeriesRepository $repository
    ): AuthorRepository|BookRepository|CategoryRepository|SeriesRepository {
        $orderField = $this->getOrderField();
        if ($orderField !== '') {
            $orderings = [$orderField => $this->getOrderDirection()];
        } else {
            $orderings = is_array($this->settings['orderings'] ?? false)
                ? $this->settings['orderings']
                : [];
        }
        if (!empty($orderings)) {
            $repository->setDefaultOrderings($orderings);
        }

        return $repository;
    }

    protected function getOrderField(): string
    {
        $allowedOrderFields = GeneralUtility::trimExplode(',', $this->settings['allowedOrderBy'] ?? '');
        $orderField = $this->request->hasArgument('orderBy')
            ? $this->request->getArgument('orderBy')
            : ($this->settings['orderBy'] ?? '');
        if (!in_array($orderField, $allowedOrderFields)) {
            $orderField = '';
        }
        return $orderField;
    }

    protected function getOrderDirection(): string
    {
        $allowedOrderDirections = [QueryInterface::ORDER_ASCENDING, QueryInterface::ORDER_DESCENDING];
        $orderDirection = $this->request->hasArgument('orderDir')
            ? $this->request->getArgument('orderDir')
            : ($this->settings['orderDir'] ?? '');
        if (!in_array($orderDirection, $allowedOrderDirections)) {
            $orderDirection = QueryInterface::ORDER_ASCENDING;
        }
        return $orderDirection;
    }

    protected function initializeView(ViewInterface $view): void
    {
        if (method_exists($view, 'getTemplateRootPaths') && method_exists($view, 'setTemplateRootPaths')) {
            $paths = $view->getTemplateRootPaths();
            foreach ($paths as &$path) {
                if (str_contains($path, ':/')) {
                    preg_match('@(?<folder>\d:/.+)@', $path, $matches);
                    if (!empty($matches['folder'] ?? '')) {
                        /** @var ResourceFactory $resourceFactory */
                        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
                        $folder = $resourceFactory->getFolderObjectFromCombinedIdentifier($matches['folder']);
                        $path = Environment::getPublicPath() . $folder->getPublicUrl();
                    }
                }
            }
            $view->setTemplateRootPaths($paths);
        }
    }

    protected function setPageTitle(string $title): void
    {
        /** @var TitleTagProvider $provider */
        $provider = GeneralUtility::makeInstance(TitleTagProvider::class);
        $provider->setTitle($title);
    }

    protected function displayError(string $type): void
    {
        /** @var ErrorController $errorController */
        $errorController = GeneralUtility::makeInstance(ErrorController::class);
        $response = $errorController->pageNotFoundAction(
            $this->request,
            'Page Not Found',
            [
                'The page did not exist or was inaccessible.',
                ' Reason: ' . $type . ' not found!',
            ]
        );
        throw new ImmediateResponseException($response);
    }

    /**
     * @param QueryResultInterface<int, Author>|QueryResultInterface<int, Book>|QueryResultInterface<int, Category>|array<int, Series> $result
     */
    protected function addPaginatorToView(QueryResultInterface|array $result): void
    {
        $paginator = $this->getPaginator($result);
        $pagination = $this->getPagination($paginator);

        $this->view->assignMultiple(
            [
                'paginator' => $paginator,
                'pagination' => $pagination,
                'pages' => range($pagination->getFirstPageNumber(), $pagination->getLastPageNumber()),
            ]
        );
    }

    /**
     * @param QueryResultInterface<int, AbstractEntity>|array<int, AbstractEntity> $result
     */
    protected function getPaginator(QueryResultInterface|array $result): PaginatorInterface
    {
        $currentPage = $this->request->hasArgument('currentPage')
            ? $this->request->getArgument('currentPage')
            : 1;

        $paginatorClass = is_array($result) ? ArrayPaginator::class : QueryResultPaginator::class;

        /** @var PaginatorInterface $resultPaginator */
        $resultPaginator = GeneralUtility::makeInstance(
            $paginatorClass,
            $result,
            (int)$currentPage,
            (int)($this->settings['itemsPerPage'] ?? 10)
        );
        return $resultPaginator;
    }

    protected function getPagination(PaginatorInterface $paginator): PaginationInterface
    {
        $paginationClass = (string)($this->settings['pagination'] ?? '');
        if (
            $paginationClass === ''
            || !class_exists($paginationClass)
            || !in_array(PaginationInterface::class, class_implements($paginationClass))
        ) {
            $paginationClass = SimplePagination::class;
        }

        /** @var PaginationInterface $pagination */
        $pagination = GeneralUtility::makeInstance(
            $paginationClass,
            $paginator,
            (int)$this->settings['numberOfLinks']
        );
        return $pagination;
    }
}
