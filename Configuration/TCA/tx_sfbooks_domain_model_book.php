<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';
$languageFileTtc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
$languageFileTca = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfbooks_domain_model_book');

return [
    'ctrl' => [
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'title' => $languageFile . 'tx_sfbooks_domain_model_book',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY title',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'iconfile' => 'EXT:sf_books/Resources/Public/Icons/tx_sfbooks_domain_model_book.svg',
        'searchFields' => 'uid, title, subtitle, isbn, description',
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
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required',
            ],
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title', 'subtitle'],
                    'fieldSeparator' => '-',
                    'replacements' => [
                        '/' => '-'
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'subtitle' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'author' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.author',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_sfbooks_domain_model_author',
                'foreign_table' => 'tx_sfbooks_domain_model_author',
                'MM' => 'tx_sfbooks_domain_model_book_author_mm',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'setValue' => 'prepend',
                        ],
                    ],
                ],
            ],
        ],
        'isbn' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.isbn',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'series' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.series',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'allowed' => 'tx_sfbooks_domain_model_series',
                'foreign_table' => 'tx_sfbooks_domain_model_series',
                'foreign_table_where' => 'AND tx_sfbooks_domain_model_series.pid = ###CURRENT_PID###
                    ORDER BY tx_sfbooks_domain_model_series.uid',
                'MM' => 'tx_sfbooks_domain_model_book_series_mm',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'setValue' => 'prepend',
                        ],
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'number' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.number',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'category' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_category.title',
                'MM' => 'tx_sfbooks_domain_model_book_category_mm',
                'minitems' => 0,
                'maxitems' => 100,
                'size' => 10,
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => 1,
                        'showHeader' => 1,
                    ],
                ],
            ],
        ],
        'location1' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location1',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'tx_sfbooks_domain_model_book.location1.I.0',
                        0,
                    ],
                ],
            ],
        ],
        'location2' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location2',
            'onChange' => 'reload',
            'displayCond' => 'FIELD:location1:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'tx_sfbooks_domain_model_book.location2.I.0',
                        0,
                    ],
                ],
            ],
        ],
        'location3' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location3',
            'displayCond' => 'FIELD:location2:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'tx_sfbooks_domain_model_book.location3.I.0',
                        0,
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
        'extras' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.extras',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tx_sfbooks_domain_model_extras',
                'foreign_table' => 'tx_sfbooks_domain_model_extras',
                'default' => 0,
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 10,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showSynchronizationLink' => 1,
                    'enabledControls' => [
                        'info' => false,
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
            ],
        ],
        'year' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.year',
            'config' => [
                'type' => 'input',
                'size' => 4,
            ],
        ],
        'cover' => [
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.cover',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('cover', [
                'appearance' => [
                    'createNewRelationLinkTitle' => $languageFileTtc . 'images.addFileReference'
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
        'cover_large' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.cover_large',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('cover_large', [
                'appearance' => [
                    'createNewRelationLinkTitle' => $languageFileTtc . 'images.addFileReference'
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
        'sample_pdf' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.sample_pdf',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('sample_pdf', [
                'appearance' => [
                    'createNewRelationLinkTitle' => $languageFileTtc . 'images.addFileReference'
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ], 'pdf')
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;' . $languageFile . 'tx_sfbooks_domain_model_book.div_common,
                    title, subtitle, path_segment, author,
                --div--;' . $languageFile . 'tx_sfbooks_domain_model_book.div_formal,
                    isbn, series, number, category, location1, --palette--;;locations,
                --div--;' . $languageFile . 'tx_sfbooks_domain_model_book.div_content,
                    year, description, extras, cover, cover_large, sample_pdf,
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
        'locations' => [
            'showitem' => 'location2, location3'
        ],
    ],
];
