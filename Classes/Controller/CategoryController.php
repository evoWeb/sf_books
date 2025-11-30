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

namespace Evoweb\SfBooks\Controller;

use Evoweb\SfBooks\Domain\Model\Category;
use Evoweb\SfBooks\Domain\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class CategoryController extends AbstractController
{
    public function __construct(protected CategoryRepository $categoryRepository) {}

    protected function initializeAction(): void
    {
        $this->setDefaultOrderings($this->categoryRepository);
    }

    protected function initializeListAction(): void
    {
        $this->settings['category'] = GeneralUtility::intExplode(',', $this->settings['category'], true);
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
            $categories = $this->categoryRepository->findAll();
        } else {
            $categories = $this->categoryRepository->findByUids($this->settings['category']);
        }

        $categories = $this->removeExcludeCategories($categories);
        $this->view->assign('categories', $categories);
        $this->addPaginatorToView($categories);

        return new HtmlResponse($this->view->render());
    }

    /**
     * @param QueryResultInterface<int, Category> $categories
     * @return QueryResultInterface<int, Category>
     */
    protected function removeExcludeCategories(QueryResultInterface $categories): QueryResultInterface
    {
        $excludeCategories = GeneralUtility::intExplode(',', $this->settings['excludeCategories'], true);
        if (count($excludeCategories)) {
            /** @var Category $category */
            foreach ($categories as $category) {
                if (in_array($category->getUid(), $excludeCategories)) {
                    $categories->offsetUnset($categories->key());
                }
            }
        }

        return $categories;
    }

    protected function showAction(?Category $category = null): ResponseInterface
    {
        if ($category == null) {
            return $this->displayError('Category');
        }

        $this->setPageTitle($category->getTitle());
        $this->view->assign('category', $category);

        return new HtmlResponse($this->view->render());
    }
}
