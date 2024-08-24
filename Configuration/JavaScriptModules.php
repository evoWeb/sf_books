<?php

return [
    'dependencies' => [
        'backend',
        'core',
    ],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        '@evoweb/sf-books/form-engine-evaluation.js' =>
            'EXT:sf_books/Resources/Public/JavaScript/form-engine-evaluation.js',
    ],
];
