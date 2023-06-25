<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'list_type',
    'sf_books',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_group'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_book'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_book'] = 'layout,select_key';
ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_book',
    'FILE:EXT:sf_books/Configuration/FlexForms/book.xml'
);

ExtensionUtility::registerPlugin(
    'sf_books',
    'Book',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_book',
    'content-plugin-sfbooks-book',
    'sf_books'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_author'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_author'] = 'layout,select_key';
ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_author',
    'FILE:EXT:sf_books/Configuration/FlexForms/author.xml'
);

ExtensionUtility::registerPlugin(
    'sf_books',
    'Author',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_author',
    'content-plugin-sfbooks-author',
    'sf_books'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_category'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_category'] = 'layout,select_key';
ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_category',
    'FILE:EXT:sf_books/Configuration/FlexForms/category.xml'
);

ExtensionUtility::registerPlugin(
    'sf_books',
    'Category',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_category',
    'content-plugin-sfbooks-category',
    'sf_books'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_search'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_search'] = 'layout,select_key';
ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_search',
    'FILE:EXT:sf_books/Configuration/FlexForms/search.xml'
);

ExtensionUtility::registerPlugin(
    'sf_books',
    'Search',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_search',
    'content-plugin-sfbooks-search',
    'sf_books'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_series'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_series'] = 'layout,select_key';
ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_series',
    'FILE:EXT:sf_books/Configuration/FlexForms/series.xml'
);

ExtensionUtility::registerPlugin(
    'sf_books',
    'Series',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_series',
    'content-plugin-sfbooks-series',
    'sf_books'
);
