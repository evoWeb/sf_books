<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2003 Sebastian Fischer <typo3@evoweb.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Plugin 'Book Library - Series' for the 'sf_books' extension.
 *
 * @author Sebastian Fischer <typo3@evoweb.de>
 */
class Tx_SfBooks_Controller_SeriesController extends Tx_SfBooks_Controller_AbstractController {
	/**
	 * @var array
	 */
	protected $allowedOrderBy = array('title');

	/**
	 * @var Tx_SfBooks_Domain_Repository_SeriesRepository
	 */
	protected $repository;

	/**
	 * @return void
	 */
	protected function initializeAction() {
		$this->repository = $this->objectManager->get('Tx_SfBooks_Domain_Repository_SeriesRepository');
		$this->setDefaultOrderings();
	}

	/**
	 * @return void
	 */
	protected function initializeListAction() {
	}

	/**
	 * renders the list of books with search and pagination
	 *
	 * @return void
	 */
	protected function listAction() {
		$seriesGroups = $this->repository->findSeriesGroupedByLetters();

		$this->view->assign('seriesGroups', $seriesGroups);
	}

	/**
	 * @return void
	 */
	protected function initializeShowAction() {
	}

	/**
	 * renders the content for a single series
	 *
	 * @param Tx_SfBooks_Domain_Model_Series $series
	 * @return void
	 */
	protected function showAction(Tx_SfBooks_Domain_Model_Series $series) {
			// This sets the title of the page for use in indexed search results:
		if ($series->getTitle()) {
			$GLOBALS['TSFE']->indexedDocTitle = $series->getTitle();
		}

		$this->view->assign('series', $series);
	}


	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param Tx_Extbase_MVC_View_ViewInterface $view The view to be initialized
	 * @return void
	 */
	protected function initializeView(Tx_Extbase_MVC_View_ViewInterface $view) {
		if (isset($this->settings['templatePath']) && !empty($this->settings['templatePath'])) {
			/** @var $view Tx_Fluid_View_TemplateView */
			$view->setTemplateRootPath(array_shift(explode(' ', $this->settings['templatePath'])));
		}
	}
}



if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/sf_books/Classes/Controller/SeriesController.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/sf_books/Classes/Controller/SeriesController.php']);
}

?>