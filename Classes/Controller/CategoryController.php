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

use Evoweb\SfBooks\Domain\Model\Category;
use Evoweb\SfBooks\Domain\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class CategoryController extends AbstractController
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    protected function initializeAction()
    {
        $this->setDefaultOrderings($this->categoryRepository);
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
            || (count($this->settings['category']) == 1 && reset($this->settings['category']) < 1)
        ) {
            $categories = $this->categoryRepository->findAll();
        } else {
            $categories = $this->categoryRepository->findByCategories($this->settings['category']);
        }

        $categories = $this->removeExcludeCategories($categories);
        $this->view->assign('categories', $categories);

        return new HtmlResponse($this->view->render());
    }

    protected function removeExcludeCategories(QueryResultInterface $categories): QueryResultInterface
    {
        $excludeCategories = GeneralUtility::intExplode(',', $this->settings['excludeCategories']);
        if (count($excludeCategories)) {
            /** @var \Evoweb\SfBooks\Domain\Model\Category $category */
            foreach ($categories as $category) {
                if (in_array($category->getUid(), $excludeCategories)) {
                    $categories->offsetUnset($categories->key());
                }
            }
        }

        return $categories;
    }

    protected function showAction(Category $category = null): ResponseInterface
    {
        if ($category == null) {
            $this->displayError('Category');
        }

        $this->setPageTitle($category->getTitle());
        $this->view->assign('category', $category);

        return new HtmlResponse($this->view->render());
    }
}
