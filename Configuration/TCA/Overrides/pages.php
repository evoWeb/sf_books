<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::registerPageTSConfigFile(
    'sf_books',
    'Configuration/PageTS/mod.tsconfig',
    '[Book Library] Limit to records'
);
