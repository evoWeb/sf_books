<?php

defined('TYPO3') or die();

use Evoweb\SfBooks\Controller\AuthorController;
use Evoweb\SfBooks\Controller\BookController;
use Evoweb\SfBooks\Controller\CategoryController;
use Evoweb\SfBooks\Controller\SearchController;
use Evoweb\SfBooks\Controller\SeriesController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
    ExtensionUtility::configurePlugin(
        'SfBooks',
        'Book',
        [
            BookController::class => 'list, show, search',
        ]
    );

    ExtensionUtility::configurePlugin(
        'SfBooks',
        'Author',
        [
            AuthorController::class => 'list, show, search',
        ]
    );

    ExtensionUtility::configurePlugin(
        'SfBooks',
        'Category',
        [
            CategoryController::class => 'list, show',
        ]
    );

    ExtensionUtility::configurePlugin(
        'SfBooks',
        'Series',
        [
            SeriesController::class => 'list, show',
        ]
    );

    ExtensionUtility::configurePlugin(
        'SfBooks',
        'Search',
        [
            SearchController::class => 'search, startSearch',
            BookController::class => 'search',
            AuthorController::class => 'search',
        ],
        [
            SearchController::class => 'search, startSearch',
            BookController::class => 'search',
            AuthorController::class => 'search',
        ]
    );

    /**
     * Register Title Provider
     */
    ExtensionManagementUtility::addTypoScriptSetup(trim('
    config.pageTitleProviders {
        books {
            provider = Evoweb\SfBooks\TitleTagProvider\TitleTagProvider
            before = seo
            after = altPageTitle
        }
    }
    '));
});
