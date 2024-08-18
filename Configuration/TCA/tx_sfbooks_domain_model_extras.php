<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'label' => 'content',
        'label_alt' => 'label',
        'label_alt_force' => true,
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_extras',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-extras',
        ],
        'searchFields' => 'uid,label,content',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'book' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_extras.book',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'size' => 1,
                'foreign_table' => 'tx_sfbooks_domain_model_book',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_book.title',
                'items' => [
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_extras.book.I.0',
                        'value' => 0,
                    ],
                ]
            ],
        ],
        'type' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_extras.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_extras.type.I.0',
                        'value' => 0,
                    ],
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_extras.type.I.1',
                        'value' => 1,
                    ],
                ],
            ],
        ],
        'label' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_extras.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sfbooks_domain_model_extraslabels',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_extraslabels.uid',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'content' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_extras.content',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
            ],
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    book,
                    type,
                    label,
                    content,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access
            ',
        ],
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    book,
                    type,
                    label,
                    content,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access
            ',
            'columnsOverrides' => [
                'content' => [
                    'config' => [
                        'enableRichtext' => true,
                        'richtextConfiguration' => 'default',
                    ],
                ],
            ],
        ],
    ],

    'palettes' => [
        'hidden' => [
            'showitem' => '
                hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden
            ',
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--,
                fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel
            ',
        ],
    ],
];
