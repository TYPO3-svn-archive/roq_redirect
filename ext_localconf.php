<?php

if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

// Hook to be called BEFORE TYPO3 starts site rendering (first possible hook to take)
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][] = 'EXT:roq_redirect/Classes/Hooks/PreprocessRequest.php:ROQUIN\\RoqRedirect\\Hooks\\PreprocessRequest->preprocessRequest';

?>