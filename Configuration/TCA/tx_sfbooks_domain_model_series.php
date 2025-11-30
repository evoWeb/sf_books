<?php

defined('TYPO3') or die();

$languageFile = 'sf_books.db:';

return [
    'ctrl' => [
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_series',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY title',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-series',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'title' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_series.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_series.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'info' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_series.info',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
            ],
        ],
        'capital_letter' => [
            'config' => [
                'type' => 'input',
                'size' => 4,
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_series.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 30,
                'rows' => 5,
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'books' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.books',
            'config' => [
                'type' => 'group',
                'size' => 5,
                'autoSizeMax' => 10,
                'allowed' => 'tx_sfbooks_domain_model_book',
                'foreign_table' => 'tx_sfbooks_domain_model_book',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_book.title',
                'MM' => 'tx_sfbooks_domain_model_book_series_mm',
                'MM_opposite_field' => 'series',
                'relationship' => 'oneToMany',
            ],
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, path_segment, info, description,
                --div--;' . $languageFile . 'div.references,
                    books,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;;visibility,
                    --palette--;;access,
            ',
        ],
    ],

    'palettes' => [
        'visibility' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility',
            'showitem' => '
                hidden;' . $languageFile . 'tx_sfbooks_domain_model_series.hidden
            ',
        ],
        'access' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access',
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.endtime_formlabel,
                --linebreak--,
                fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.fe_group_formlabel
            ',
        ],
    ],
];
