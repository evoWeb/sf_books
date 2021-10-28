<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'label' => 'title',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'title' => $languageFile . 'tx_sfbooks_domain_model_category',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'iconfile' => 'EXT:sf_books/Resources/Public/Icons/tx_sfbooks_domain_model_category.svg',
        'searchFields' => 'uid, title',
    ],

    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'fe_group' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'size' => 5,
                'maxitems' => 20,
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login',
                        -1
                    ],
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login',
                        -2
                    ],
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups',
                        '--div--'
                    ]
                ],
                'exclusiveKeys' => '-1,-2',
                'foreign_table' => 'fe_groups',
                'foreign_table_where' => 'ORDER BY fe_groups.title',
            ]
        ],

        'title' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 150,
                'eval' => 'required',
            ],
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'parent' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_table_where' => 'tx_sfbooks_domain_model_category.uid != '
                    . '###THIS_UID### ORDER BY tx_sfbooks_domain_model_category.title',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => false,
                        'showHeader' => false,
                        'maxLevels' => 99,
                    ],
                ],
                'size' => 7,
                'minitems' => 0,
            ],
        ],
        'children' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_category.children',
            'config' => [
                'type' => 'inline',
                'readOnly' => true,
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_field' => 'parent',
                'maxitems' => 10,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'enabledControls' => [
                        'info' => false,
                        'new' => false,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => false,
                        'delete' => false,
                        'localize' => false,
                    ]
                ],
                'overrideChildTca' => [
                    'columns' => [
                        'title' => [
                            'label' => $languageFile . 'tx_sfbooks_domain_model_category.title',
                            'config' => [
                                'type' => 'input',
                                'readOnly' => true,
                                'size' => 30,
                                'max' => 100,
                                'eval' => 'required',
                            ],
                        ],
                    ],
                    'types' => [
                        '0' => [
                            'showitem' => 'title',
                        ],
                    ],
                ],
            ],
        ],
        'description' => [
            'exclude' => 1,
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
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.books',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
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
            '
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
