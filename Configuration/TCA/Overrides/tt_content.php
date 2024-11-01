<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

(static function () {
    $languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';
    $GLOBALS['TCA']['tt_content']['palettes']['storefinder-frames'] = [
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames',
        'showitem' => '
            frame_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:frame_class_formlabel,
            space_before_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_before_class_formlabel,
            space_after_class;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:space_after_class_formlabel
        '
    ];

    $showItems = '
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin,
            pi_flexform,
            pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,
            recursive,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
            --palette--;;storefinder-frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
    ';

    ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'list_type',
        'sf_books',
        $languageFile . 'tt_content.list_type_group'
    );

    ExtensionUtility::registerPlugin(
        'sf_books',
        'Book',
        $languageFile . 'tt_content.list_type_book',
        'content-plugin-sfbooks-book',
        'sf_books'
    );
    $GLOBALS['TCA']['tt_content']['types']['sfbooks_book']['showitem'] = $showItems;

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sf_books/Configuration/FlexForms/book.xml',
        'sfbooks_book'
    );

    ExtensionUtility::registerPlugin(
        'sf_books',
        'Author',
        $languageFile . 'tt_content.list_type_author',
        'content-plugin-sfbooks-author',
        'sf_books'
    );
    $GLOBALS['TCA']['tt_content']['types']['sfbooks_author']['showitem'] = $showItems;

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sf_books/Configuration/FlexForms/author.xml',
        'sfbooks_author'
    );

    ExtensionUtility::registerPlugin(
        'sf_books',
        'Category',
        $languageFile . 'tt_content.list_type_category',
        'content-plugin-sfbooks-category',
        'sf_books'
    );
    $GLOBALS['TCA']['tt_content']['types']['sfbooks_category']['showitem'] = $showItems;

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sf_books/Configuration/FlexForms/category.xml',
        'sfbooks_category'
    );

    ExtensionUtility::registerPlugin(
        'sf_books',
        'Search',
        $languageFile . 'tt_content.list_type_search',
        'content-plugin-sfbooks-search',
        'sf_books'
    );
    $GLOBALS['TCA']['tt_content']['types']['sfbooks_search']['showitem'] = $showItems;

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sf_books/Configuration/FlexForms/search.xml',
        'sfbooks_search'
    );

    ExtensionUtility::registerPlugin(
        'sf_books',
        'Series',
        $languageFile . 'tt_content.list_type_series',
        'content-plugin-sfbooks-series',
        'sf_books'
    );
    $GLOBALS['TCA']['tt_content']['types']['sfbooks_series']['showitem'] = $showItems;

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sf_books/Configuration/FlexForms/series.xml',
        'sfbooks_series'
    );
})();
