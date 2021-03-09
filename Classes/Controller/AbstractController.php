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

use Evoweb\SfBooks\TitleTagProvider\TitleTagProvider;
use TYPO3\CMS\Core\Controller\ErrorPageController;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

abstract class AbstractController extends ActionController
{
    protected array $allowedOrderBy = [];

    /**
     * @var Repository
     */
    protected $repository;

    protected function initializeAction()
    {
        $this->setDefaultOrderings();
    }

    protected function setDefaultOrderings()
    {
        if (isset($this->settings['allowedOrderBy'])) {
            $this->allowedOrderBy = GeneralUtility::trimExplode(',', $this->settings['allowedOrderBy']);
        }

        $orderBy = $orderDir = '';
        if (
            $this->request->hasArgument('orderBy')
            && in_array($this->request->getArgument('orderBy'), $this->allowedOrderBy)
        ) {
            $orderBy = $this->request->getArgument('orderBy');
        } elseif (in_array($this->settings['orderBy'], $this->allowedOrderBy)) {
            $orderBy = $this->settings['orderBy'];
        }

        if (
            $this->request->hasArgument('orderDir')
            && (
                $this->request->getArgument('orderDir') == QueryInterface::ORDER_ASCENDING
                || $this->request->getArgument('orderDir') == QueryInterface::ORDER_DESCENDING
            )
        ) {
            $orderDir = $this->request->getArgument('orderDir');
        } elseif (
            $this->settings['orderDir'] == QueryInterface::ORDER_ASCENDING
            || $this->settings['orderDir'] == QueryInterface::ORDER_DESCENDING
        ) {
            $orderDir = $this->settings['orderDir'];
        }

        if (empty($orderDir)) {
            $orderDir = QueryInterface::ORDER_ASCENDING;
        }

        if ($orderBy) {
            $defaultOrderings = array_merge([$orderBy => $orderDir], (array)$this->settings['orderings']);
            $this->repository->setDefaultOrderings($defaultOrderings);
        }
    }

    protected function setPageTitle(string $title)
    {
        /** @var TitleTagProvider $provider */
        $provider = GeneralUtility::makeInstance(TitleTagProvider::class);
        $provider->setTitle($title);
    }

    protected function displayError(string $type)
    {
        /** @var \TYPO3\CMS\Core\Controller\ErrorPageController $errorController */
        $errorController = GeneralUtility::makeInstance(ErrorPageController::class);
        echo $errorController->errorAction(
            'Page Not Found',
            'The page did not exist or was inaccessible. Reason: ' . $type . ' not found'
        );
        die();
    }

    protected function addPaginator(QueryResultInterface $result)
    {
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->hasArgument('currentPage') : 1;

        $resultPaginator = new QueryResultPaginator($result, $currentPage, (int)$this->settings['limit']);
        $pagination = new SimplePagination($resultPaginator);

        $this->view->assignMultiple(
            [
                'paginator' => $resultPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]
        );
    }
}
