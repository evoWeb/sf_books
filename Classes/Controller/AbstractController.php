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

use Evoweb\SfBooks\TitleTagProvider\TitleTagProvider;
use JetBrains\PhpStorm\NoReturn;
use TYPO3\CMS\Core\Controller\ErrorPageController;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3Fluid\Fluid\View\ViewInterface;

abstract class AbstractController extends ActionController
{
    protected function setDefaultOrderings(Repository $repository): Repository
    {
        $allowedOrderBy = [];
        if (isset($this->settings['allowedOrderBy'])) {
            $allowedOrderBy = GeneralUtility::trimExplode(',', $this->settings['allowedOrderBy']);
        }

        $orderBy = $orderDir = '';
        if (
            $this->request->hasArgument('orderBy')
            && in_array($this->request->getArgument('orderBy'), $allowedOrderBy)
        ) {
            $orderBy = $this->request->getArgument('orderBy');
        } elseif (in_array($this->settings['orderBy'], $allowedOrderBy)) {
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
            $repository->setDefaultOrderings($defaultOrderings);
        }

        return $repository;
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

    #[NoReturn]
    protected function displayError(string $type): void
    {
        /** @var ErrorPageController $errorController */
        $errorController = GeneralUtility::makeInstance(ErrorPageController::class);
        echo $errorController->errorAction(
            'Page Not Found',
            'The page did not exist or was inaccessible.' . ($type ? ' Reason: ' . $type : ' not found!'),
            0,
            503
        );
        die();
    }

    protected function addPaginator(QueryResultInterface $result): void
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
