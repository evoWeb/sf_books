<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

call_user_func(static function () {
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
        'CType',
        'sf_books',
        $languageFile . 'tt_content.list_type_group'
    );

    foreach (['Book', 'Author', 'Category', 'Search', 'Series'] as $cType) {
        $lowerCType = strtolower($cType);
        $signature = ExtensionUtility::registerPlugin(
            'sf_books',
            $cType,
            $languageFile . 'tt_content.list_type_' . $lowerCType,
            'content-plugin-sfbooks-' . $lowerCType,
            'sf_books',
            $languageFile . 'tt_content.list_type_' . $lowerCType . '_description',
        );
        $GLOBALS['TCA']['tt_content']['types'][$signature]['showitem'] = $showItems;
        $GLOBALS['TCA']['tt_content']['types'][$signature]['columnsOverrides']['pi_flexform']['config']['ds'] =
            'FILE:EXT:sf_books/Configuration/FlexForms/' . $lowerCType . '.xml';
    }
});
