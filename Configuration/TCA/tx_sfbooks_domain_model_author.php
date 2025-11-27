<?php

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sf_books/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'label' => 'lastname',
        'label_alt' => 'firstname',
        'label_alt_force' => '1',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => $languageFile . 'tx_sfbooks_domain_model_author',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY lastname, firstname',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'sf-books-author',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],

    'columns' => [
        'lastname' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.lastname',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'firstname' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.firstname',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
            ],
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['lastname', 'firstname'],
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
        'description' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_sfbooks_domain_model_author.description',
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
                'size' => 5,
                'autoSizeMax' => 10,
                'foreign_table' => 'tx_sfbooks_domain_model_book',
                'foreign_table_where' => 'ORDER BY tx_sfbooks_domain_model_book.title',
                'MM' => 'tx_sfbooks_domain_model_book_author_mm',
                'MM_opposite_field' => 'author',
                'relationship' => 'oneToMany',
            ],
        ],
        'capital_letter' => [
            'config' => [
                'type' => 'input',
            ],
        ],
    ],

    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    lastname, firstname, path_segment, description,
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
