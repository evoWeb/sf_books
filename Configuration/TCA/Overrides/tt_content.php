<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

call_user_func(static function () {
    ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'CType',
        'sf_books',
        'sf_books.db:tt_content.list_type_group'
    );

    foreach (['Book', 'Author', 'Category', 'Search', 'Series'] as $cType) {
        $lowerCType = strtolower($cType);
        ExtensionUtility::registerPlugin(
            'sf_books',
            $cType,
            'sf_books.db:tt_content.list_type_' . $lowerCType,
            'content-plugin-sfbooks-' . $lowerCType,
            'sf_books',
            'sf_books.db:tt_content.list_type_' . $lowerCType . '_description',
            'FILE:EXT:sf_books/Configuration/FlexForms/' . $lowerCType . '.xml'
        );
    }
});
