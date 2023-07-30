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

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

class SearchController extends AbstractController
{
    public function searchAction(): ResponseInterface
    {
        return new HtmlResponse($this->view->render());
    }

    public function startSearchAction(array $search): ResponseInterface
    {
        if (($search['query'] ?? '') != '') {
            if (isset($search['searchBy'])) {
                switch ((string)$search['searchFor'] ?? '') {
                    case 'author':
                        $controller = 'Author';
                        $pageId = (int)$this->settings['authorPageId'];
                        break;

                    case 'book':
                    default:
                        $controller = 'Book';
                        $pageId = (int)$this->settings['bookPageId'];
                }

                if (!$pageId) {
                    $pageId = $this->request->getAttribute('currentContentObject')->data['pid'];
                }

                $this->redirect('search', $controller, null, $search, $pageId, $controller);
            }
            $response = new HtmlResponse($this->view->render());
        } else {
            $response = new ForwardResponse('search');
        }

        return $response;
    }

    protected function redirect(
        $actionName,
        $controllerName = null,
        $extensionName = null,
        array $arguments = null,
        $pageUid = null,
        $_ = null,
        $statusCode = 303
    ): ResponseInterface {
        if ($controllerName === null) {
            $controllerName = $this->request->getControllerName();
        }
        $this->uriBuilder->reset()->setCreateAbsoluteUri(true);
        if (MathUtility::canBeInterpretedAsInteger($pageUid)) {
            $this->uriBuilder->setTargetPageUid((int)$pageUid);
        }
        if (GeneralUtility::getIndpEnv('TYPO3_SSL')) {
            $this->uriBuilder->setAbsoluteUriScheme('https');
        }
        $uri = $this->uriBuilder->uriFor($actionName, $arguments, $controllerName, $extensionName, $controllerName);
        return $this->redirectToUri($uri, null, $statusCode);
    }
}
