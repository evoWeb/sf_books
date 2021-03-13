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

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

class SearchController extends AbstractController
{
    public function searchAction(): ResponseInterface
    {
        return new HtmlResponse($this->view->render());
    }

    public function startSearchAction(array $search): ResponseInterface
    {
        if (is_array($search) && isset($search['query']) && $search['query'] != '') {
            if (isset($search['searchBy'])) {
                switch ((string)$search['searchFor']) {
                    case 'author':
                        $controller = 'Author';
                        $pageId = (int)$this->settings['authorPageId'];
                        break;

                    case 'book':
                    default:
                        $pageId = (int)$this->settings['bookPageId'];
                        $controller = 'Book';
                }

                if (!$pageId) {
                    $pageId = $this->configurationManager->getContentObject()->data['pid'];
                }

                $this->redirect('search', $controller, null, $search, $pageId);
            }
            $response = new HtmlResponse($this->view->render());
        } else {
            $response = new ForwardResponse('search');
        }

        return $response;
    }
}
