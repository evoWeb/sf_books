<?php

$EM_CONF['sf_books'] = [
    'title' => 'Book Library',
    'description' => 'Managing lots of books is not easy without a good tool.
The book library tries to help you keeping an overview your
books and to search easily information about each book.',
    'category' => 'plugin',
    'author' => 'Sebastian Fischer',
    'author_email' => 'typo3@evoweb.de',
    'author_company' => 'evoWeb',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '5.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
    ],
];
