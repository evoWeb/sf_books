<?php

defined('TYPO3') or die();

use Evoweb\SfBooks\User\IsbnEvaluation;
use TYPO3\CMS\Core\Resource\FileType;

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';
$languageFileTtc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
$languageFileTca = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:';

return [
    'ctrl' => [
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_book',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY title',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-book',
        ],
        'searchFields' => 'uid, title, subtitle, isbn, description',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'title' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'required' => true,
            ],
        ],
        'subtitle' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
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
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],
        'author' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.author',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_sfbooks_domain_model_author',
                'foreign_table' => 'tx_sfbooks_domain_model_author',
                'MM' => 'tx_sfbooks_domain_model_book_author_mm',
                'relationship' => 'oneToMany',
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
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.isbn',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 17,
                'eval' => 'trim,' . IsbnEvaluation::class,
            ],
        ],
        'series' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.series',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'allowed' => 'tx_sfbooks_domain_model_series',
                'foreign_table' => 'tx_sfbooks_domain_model_series',
                'foreign_table_where' => 'AND tx_sfbooks_domain_model_series.pid = ###CURRENT_PID###
                    ORDER BY tx_sfbooks_domain_model_series.uid',
                'MM' => 'tx_sfbooks_domain_model_book_series_mm',
                'relationship' => 'oneToOne',
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
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.number',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'category' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_sfbooks_domain_model_category',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_category.title',
                'MM' => 'tx_sfbooks_domain_model_book_category_mm',
                'relationship' => 'oneToMany',
                'minitems' => 0,
                'maxitems' => 100,
                'size' => 10,
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
            ],
        ],
        'location1' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location1',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_book.location1.I.0',
                        'value' => 0,
                    ],
                ],
            ],
        ],
        'location2' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location2',
            'onChange' => 'reload',
            'displayCond' => 'FIELD:location1:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_book.location2.I.0',
                        'value' => 0,
                    ],
                ],
            ],
        ],
        'location3' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.location3',
            'displayCond' => 'FIELD:location2:REQ:true',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'tx_sfbooks_domain_model_book.location3.I.0',
                        'value' => 0,
                    ],
                ],
            ],
        ],
        'description' => [
            'exclude' => false,
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
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.extras',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sfbooks_domain_model_extras',
                'foreign_field' => 'book',
                'relationship' => 'oneToMany',
                'maxitems' => 10,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'year' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.year',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'max' => 4,
            ],
        ],
        'cover' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.cover',
            'config' => [
                'type' => 'file',
                'relationship' => 'oneToMany',
                'allowed' => 'common-image-types',
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::TEXT->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::AUDIO->value => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::VIDEO->value => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::APPLICATION->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],
        'cover_large' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.cover_large',
            'config' => [
                'type' => 'file',
                'relationship' => 'oneToMany',
                'allowed' => 'common-image-types',
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::TEXT->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::AUDIO->value => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::VIDEO->value => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::APPLICATION->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],
        'sample_pdf' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_book.sample_pdf',
            'config' => [
                'type' => 'file',
                'relationship' => 'oneToMany',
                'allowed' => 'pdf',
                'appearance' => [
                    'createNewRelationLinkTitle' =>
                        'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // to use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::TEXT->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::IMAGE->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::AUDIO->value => [
                            'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::VIDEO->value => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
                        ],
                        FileType::APPLICATION->value => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
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
        'locations' => [
            'showitem' => 'location2, location3',
        ],
    ],
];
