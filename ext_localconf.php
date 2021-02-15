<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    $icons = [
        'book',
        'author',
        'category',
        'search',
        'series',
    ];

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'content-plugin-sfbooks-' . $icon,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:sf_books/Resources/Public/Icons/Extension.svg']
        );
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import \'EXT:sf_books/Configuration/TSconfig/NewContentElementWizard.typoscript\''
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SfBooks',
        'Book',
        [
            \Evoweb\SfBooks\Controller\BookController::class => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SfBooks',
        'Author',
        [
            \Evoweb\SfBooks\Controller\AuthorController::class => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SfBooks',
        'Category',
        [
            \Evoweb\SfBooks\Controller\CategoryController::class => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SfBooks',
        'Series',
        [
            \Evoweb\SfBooks\Controller\SeriesController::class => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SfBooks',
        'Search',
        [
            \Evoweb\SfBooks\Controller\SearchController::class => 'search, startSearch',
        ],
        [
            \Evoweb\SfBooks\Controller\SearchController::class => 'search, startSearch',
        ]
    );

    /**
     * Register Title Provider
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        trim(
            '
    config.pageTitleProviders {
        books {
            provider = Evoweb\SfBooks\TitleTagProvider\TitleTagProvider
            before = seo
            after = altPageTitle
        }
    }
'
        )
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['sfBooksAuthorsSlugs']
        = \Evoweb\SfBooks\Updates\PopulateAuthorSlugs::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['sfBooksBooksSlugs']
        = \Evoweb\SfBooks\Updates\PopulateBookSlugs::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['sfBooksCategoriesSlugs']
        = \Evoweb\SfBooks\Updates\PopulateCategorySlugs::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['sfBooksSeriesSlugs']
        = \Evoweb\SfBooks\Updates\PopulateSeriesSlugs::class;
});
