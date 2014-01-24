<?php
namespace ROQUIN\RoqRedirect\Hooks;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Patrick Wiggelman <patrick@roquin.nl>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Hook into index_ts.php to manipulate the url for redirect
 *
 * @author Patrick Wiggelman <patrick@roquin.nl>
 * @package TYPO3
 * @subpackage roq_redirect
 */

use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use ROQUIN\RoqRedirect\Utility\Http;

class PreprocessRequest {

    /**
     * Redirect if request matches a redirect in db
     *
     * @return void
     */
    public function preprocessRequest() {
        $redirect   = null;
        $requestUrl = substr($_SERVER['REQUEST_URI'], 1);

        // Check if there is a request uri and check if there is a redirect available
        if($requestUrl) {
            $redirect = $this->redirectAvailable($requestUrl);
        }

        // Do the actual redirect
        if($redirect) {
            $GLOBALS['TSFE'] = new TypoScriptFrontendController($GLOBALS['TYPO3_CONF_VARS'], 0, 0, 1);
            $GLOBALS['TSFE']->connectToDB();
            $GLOBALS['TSFE']->initFEuser();
            $GLOBALS['TSFE']->fetch_the_id();
            $GLOBALS['TSFE']->getPageAndRootline();
            $GLOBALS['TSFE']->initTemplate();
            $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_site;
            $GLOBALS['TSFE']->forceTemplateParsing = 1;
            $GLOBALS['TSFE']->getConfigArray();
            $GLOBALS['TSFE']->cObj = new ContentObjectRenderer();

            $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
                 array(
                     'parameter' => (int)$redirect->getRedirectTo(),
                     'additionalParams' => '&L=' . $redirect->getLanguageUid()
                 )
            );

            \TYPO3\CMS\Core\Utility\HttpUtility::redirect($url, Http::getHttpStatus($redirect->getHttpCode()));
        }
    }

    /**
     * Get the matching redirect from request if exist
     *
     * @param   string $requestUrl
     * @return  NULL|\ROQUIN\RoqRedirect\Domain\Model\Redirect
     */
    private function redirectAvailable($requestUrl) {
        $redirect       = null;
        $requestDomain  = $_SERVER['SERVER_NAME'];

        $domainRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
            '*',
            'sys_domain',
            "domainName = '" . $requestDomain . "' AND hidden = 0"
        );

        // search for a matching redirect
        if(isset($domainRecord)) {

            /** @var \ROQUIN\RoqRedirect\Domain\Model\Domain $domain */
            $domain = new \ROQUIN\RoqRedirect\Domain\Model\Domain;
            $domain->setPid($domainRecord['pid']);
            $domain->setDomainName($domainRecord['domainName']);

            $where = "pid = '" . $domain->getPid() . "'
                AND redirect_url = '" . $requestUrl . "'
                AND deleted = 0 AND hidden = 0
                AND starttime <= '" . $GLOBALS['SIM_ACCESS_TIME'] . "'
                AND (endtime=0 OR endtime > '" .  $GLOBALS['SIM_ACCESS_TIME'] . "')";

            $redirectRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
                '*',
                'tx_roqredirect_domain_model_redirect',
                $where
            );

            if(isset($redirectRecord) && $redirectRecord !== FALSE) {
                /** @var \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect */
                $redirect =  new \ROQUIN\RoqRedirect\Domain\Model\Redirect;
                $redirect->setPid($redirectRecord['pid']);
                $redirect->setHttpCode($redirectRecord['http_code']);
                $redirect->setRedirectTo($redirectRecord['redirect_to']);
                $redirect->setRedirectUrl($redirectRecord['redirect_url']);
                $redirect->setLanguageUid($redirectRecord['sys_language_uid']);
            }
        }
        
        return $redirect;
    }

}

?>