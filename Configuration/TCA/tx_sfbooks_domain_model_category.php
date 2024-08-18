<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'label' => 'title',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_category',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-author',
        ],
        'searchFields' => 'title, description',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'title' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.title',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'parent' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_table_where' => '{#tx_sfbooks_domain_model_category}.{#uid} != ###THIS_UID### ORDER BY title',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => false,
                        'showHeader' => false,
                        'maxLevels' => 99,
                    ],
                ],
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'path_segment' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.path_segment',
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
        'children' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.children',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_field' => 'parent',
                'size' => 10,
                'fieldWizard' => [
                    'recordsOverview' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.description',
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
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.books',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_sfbooks_domain_model_book',
                'foreign_table' => 'tx_sfbooks_domain_model_book',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_book.title',
                'MM' => 'tx_sfbooks_domain_model_book_category_mm',
                'MM_opposite_field' => 'category',
                'size' => 7,
            ],
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, path_segment, description, parent, children,
                --div--;' . $languageFile . 'div.references,
                    books,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access
            ',
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
