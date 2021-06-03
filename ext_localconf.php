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

    if (
        \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(
            \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()
        ) < 10000000
    ) {
        // @todo remove once TYPO3 9.5.x support is dropped
        $extensionName = 'Evoweb.SfBooks';
        $authorController = 'Author';
        $bookController = 'Book';
        $categoryController = 'Category';
        $searchController = 'Search';
        $seriesController = 'Series';
    } else {
        $extensionName = 'SfBooks';
        $authorController = \Evoweb\SfBooks\Controller\AuthorController::class;
        $bookController = \Evoweb\SfBooks\Controller\BookController::class;
        $categoryController = \Evoweb\SfBooks\Controller\CategoryController::class;
        $searchController = \Evoweb\SfBooks\Controller\SearchController::class;
        $seriesController = \Evoweb\SfBooks\Controller\SeriesController::class;
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Book',
        [
            $bookController => 'list, show, search',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Author',
        [
            $authorController => 'list, show, search',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Category',
        [
            $categoryController => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Series',
        [
            $seriesController => 'list, show',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Search',
        [
            $searchController => 'search, startSearch',
        ],
        [
            $searchController => 'search, startSearch',
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
