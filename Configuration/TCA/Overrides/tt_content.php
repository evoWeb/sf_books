<?php

defined('TYPO3') or die();

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_book'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_book'] = 'layout,select_key';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_book',
    'FILE:EXT:sf_books/Configuration/FlexForms/book.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_books',
    'Book',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_book'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_author'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_author'] = 'layout,select_key';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_author',
    'FILE:EXT:sf_books/Configuration/FlexForms/author.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_books',
    'Author',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_author'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_category'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_category'] = 'layout,select_key';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_category',
    'FILE:EXT:sf_books/Configuration/FlexForms/category.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_books',
    'Category',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_category'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_series'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_series'] = 'layout,select_key';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_series',
    'FILE:EXT:sf_books/Configuration/FlexForms/series.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_books',
    'Series',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_series'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbooks_search'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbooks_search'] = 'layout,select_key';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbooks_search',
    'FILE:EXT:sf_books/Configuration/FlexForms/search.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_books',
    'Search',
    'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_search'
);
