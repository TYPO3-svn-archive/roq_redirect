<?php
namespace ROQUIN\RoqRedirect\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use ROQUIN\RoqRedirect\Utility\Http;
use ROQUIN\RoqRedirect\Utility\RedirectType;
use ROQUIN\RoqRedirect\Utility\File;

/**
 *
 *
 * @package roq_redirect
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RedirectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * domainRepository
     *
     * @var \ROQUIN\RoqRedirect\Domain\Repository\DomainRepository
     */
    protected $domainRepository;

    /**
     * redirectRepository
     *
     * @var \ROQUIN\RoqRedirect\Domain\Repository\RedirectRepository
     */
    protected $redirectRepository;

    /**
     * fileRepository
     *
     * @var \ROQUIN\RoqRedirect\Domain\Repository\FileRepository
     */
    protected $fileRepository;

    /**
     * Inject repositories
     */
    public function injectRepositories() {
        $this->domainRepository   = new \ROQUIN\RoqRedirect\Domain\Repository\DomainRepository();
        $this->redirectRepository = new \ROQUIN\RoqRedirect\Domain\Repository\RedirectRepository();
        $this->fileRepository     = new \ROQUIN\RoqRedirect\Domain\Repository\FileRepository();
    }

    /**
     * Redirect if redirect record exist
     *
     */
    public function doRedirectIfExist() {
        $this->injectRepositories();

        $requestUrl = trim(\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_SCRIPT'));

        $redirect = ($this->redirectAvailable($requestUrl)) ? $this->redirectAvailable($requestUrl) : NULL;

        // Redirect available
        if ($redirect != NULL) {
            // Exclude requests with method head used for checking url
            if ($GLOBALS['_SERVER']['REQUEST_METHOD'] !== 'HEAD') {
                // Update the visited redirect with +1
                $this->redirectRepository->updateCounter($redirect);

                switch ($redirect->getType()) {
                    // Internal page
                    case RedirectType::INTERNAL_PAGE:
                        $this->redirectToInternalPage($redirect);
                    // External url
                    case RedirectType::EXTERNAL_URL:
                        Http::redirect($redirect->getExternalUrl(), $redirect->getHttpCode());
                    // Internal file
                    case RedirectType::INTERNAL_FILE:
                        $this->redirectToInternalFile($redirect);
                        break;
                }
            }
        }
    }

    /**
     * Get the matching redirect from request if exist
     *
     * @param   string $requestUrl
     * @return  NULL|\ROQUIN\RoqRedirect\Domain\Model\Redirect
     */
    public function redirectAvailable($requestUrl) {
        $redirect      = NULL;
        $requestDomain = $_SERVER['SERVER_NAME'];

        // Get the current domain record if exist
        $currentDomainRecord = $this->domainRepository->getCurrentDomain($requestDomain);

        // search for a matching redirect if the current domain exist
        if (is_array($currentDomainRecord)) {

            /** @var \ROQUIN\RoqRedirect\Domain\Model\Domain $domain */
            $domain = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                'ROQUIN\\RoqRedirect\\Domain\\Model\\Domain'
            );
            $domain->setPid($currentDomainRecord['pid']);
            $domain->setDomainName($currentDomainRecord['domainName']);

            // Get the current domain record if exist
            $redirectRecord = $this->redirectRepository->getRedirectByDomain($domain, $requestUrl);

            if (is_array($redirectRecord)) {
                /** @var \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect */
                $redirect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    'ROQUIN\\RoqRedirect\\Domain\\Model\\Redirect'
                );
                $redirect->setPid($redirectRecord['pid']);
                $redirect->setHttpCode($redirectRecord['http_code']);
                $redirect->setRedirectTo($redirectRecord['redirect_to']);
                $redirect->setRedirectUrl($redirectRecord['redirect_url']);
                $redirect->setLanguageUid($redirectRecord['sys_language_uid']);
                $redirect->setAdditionalUrl($redirectRecord['additional_url']);
                $redirect->setExternalUrl($redirectRecord['external_url']);
                $redirect->setInternalFile($redirectRecord['internal_file']);
                $redirect->setType($redirectRecord['type']);
                $redirect->setId($redirectRecord['uid']);
            }
        }

        return $redirect;
    }

    /**
     * Redirect to internal page
     *
     * @param   \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect   redirect object
     */
    public function redirectToInternalPage($redirect) {
        // Fake a TS FE Controller to use typolink url
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            'ROQUIN\\RoqRedirect\\Utility\\FakeTypoScriptFrontendController'
        );

        // Create a typolink url
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter'        => (int)$redirect->getRedirectTo(),
                'additionalParams' => '&L=' . $redirect->getLanguageUid()
            )
        );

        // Add additional data to the typolink url for linking inside a html page
        if ($redirect->getAdditionalUrl()) {
            $url .= $redirect->getAdditionalUrl();
        }

        // Do the actual redirect
        Http::redirect($url, $redirect->getHttpCode());
    }

    /**
     * Redirect to
     *
     * @param   \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect   redirect object
     */
    public function redirectToInternalFile($redirect) {
        // Get the file record by redirect
        $fileRecord = $this->fileRepository->getFileByRedirect($redirect);

        if (is_array($fileRecord)) {
            // Get the url of the file
            $url = File::getUrl($fileRecord);

            // Do the actual redirect
            Http::redirect($url, $redirect->getHttpCode());
        }
    }
}

?>