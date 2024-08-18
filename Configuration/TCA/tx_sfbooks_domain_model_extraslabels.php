<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_extraslabels',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY crdate',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-extraslabels',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'label' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_extraslabels.label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    label,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden
            ',
        ],
    ],

    'palettes' => [
        'hidden' => [
            'showitem' => '
                hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden
            ',
        ],
    ],
];
