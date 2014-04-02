<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
    // Shows a flash message if redirect url already exist as TYPO3 page, so the redirect overrides the TYPO3 page
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/MessagePageExist.php:ROQUIN\\RoqRedirect\\Hooks\\MessagePageExist';
}

// Hook to be called BEFORE TYPO3 starts site rendering (first possible hook to take)
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/PreprocessRequest.php:ROQUIN\\RoqRedirect\\Hooks\\PreprocessRequest->preprocessRequest';

?>