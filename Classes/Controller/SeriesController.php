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

use Evoweb\SfBooks\Domain\Repository\SeriesRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;

class SeriesController extends AbstractController
{
    /**
     * @var SeriesRepository
     */
    protected $repository;

    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function listAction(): ResponseInterface
    {
        $seriesGroups = $this->repository->findSeriesGroupedByLetters();

        $this->view->assign('seriesGroups', $seriesGroups);

        return new HtmlResponse($this->view->render());
    }

    protected function showAction(\Evoweb\SfBooks\Domain\Model\Series $series = null): ResponseInterface
    {
        if ($series == null) {
            $this->displayError('Series');
        }

        $this->setPageTitle($series->getTitle());
        $this->view->assign('series', $series);

        return new HtmlResponse($this->view->render());
    }
}
