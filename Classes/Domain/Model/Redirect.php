<?php
namespace ROQUIN\RoqRedirect\Domain\Model;

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

use ROQUIN\RoqRedirect\Utility\Http;
use ROQUIN\RoqRedirect\Utility\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package roq_redirect
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Redirect extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * id
     *
     * @var int
     */
    protected $id;

    /**
     * redirectUrl
     *
     * @var string
     * @validate NotEmpty
     */
    protected $redirectUrl;

    /**
     * redirectTo
     *
     * @var string
     * @validate NotEmpty
     */
    protected $redirectTo;

    /**
     * httpCode
     *
     * @var integer
     */
    protected $httpCode;

    /**
     * languageUid
     *
     * @var int
     */
    protected $languageUid;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $counter;

    /**
     * @var string
     */
    protected $externalUrl;

    /**
     * @var string
     */
    protected $additionalUrl;

    /**
     * The internal file to redirect to
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $internalFile;

    /**
     * Returns the id
     *
     * @return int $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the id
     *
     * @param int $id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns the redirectUrl
     *
     * @return string $redirectUrl
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * Sets the redirectUrl
     *
     * @param string $redirectUrl
     * @return void
     */
    public function setRedirectUrl($redirectUrl) {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns the redirectTo
     *
     * @return string $redirectTo
     */
    public function getRedirectTo() {
        return $this->redirectTo;
    }

    /**
     * Sets the redirectTo
     *
     * @param string $redirectTo
     * @return void
     */
    public function setRedirectTo($redirectTo) {
        $this->redirectTo = $redirectTo;
    }

    /**
     * Returns the httpCode
     *
     * @return integer $httpCode
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * Sets the httpCode
     *
     * @param integer $httpCode
     * @return void
     */
    public function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
    }

    /**
     * Returns the languageUid
     *
     * @return int $languageUid
     */
    public function getLanguageUid() {
        return $this->languageUid;
    }

    /**
     * Sets the languageUid
     *
     * @param int $languageUid
     * @return void
     */
    public function setLanguageUid($languageUid) {
        $this->languageUid = $languageUid;
    }

    /**
     * Get type of redirect
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set type of redirect
     *
     * @param integer $type type
     * @return void
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * Get counter
     *
     * @return integer
     */
    public function getCounter() {
        return $this->counter;
    }

    /**
     * Set counter
     *
     * @param integer $counter counter
     * @return void
     */
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    /**
     * Get externalUrl
     *
     * @return string
     */
    public function getExternalUrl() {
        return $this->externalUrl;
    }

    /**
     * Set externalUrl
     *
     * @param string $externalUrl externalUrl
     * @return void
     */
    public function setExternalUrl($externalUrl) {
        $this->externalUrl = $externalUrl;
    }

    /**
     * Get additionalUrl
     *
     * @return string
     */
    public function getAdditionalUrl() {
        return $this->additionalUrl;
    }

    /**
     * Set additionalUrl
     *
     * @param string $additionalUrl additionalUrl
     * @return void
     */
    public function setAdditionalUrl($additionalUrl) {
        $this->additionalUrl = $additionalUrl;
    }

    /**
     * Returns the internalFile
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $internalFile
     */
    public function getInternalFile() {
        if (!is_object($this->internalFile)) {
            return NULL;
        } elseif ($this->internalFile instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->internalFile->_loadRealInstance();
        }

        return $this->internalFile->getOriginalResource();
    }

    /**
     * Sets the internal file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $internalFile
     * @return void
     */
    public function setInternalFile($internalFile) {
        $this->internalFile = $internalFile;
    }

    /**
     * Get the matching redirect from request if exist
     *
     * @param   string $requestUrl
     * @param   \ROQUIN\RoqRedirect\Domain\Repository\DomainRepository $domainRepository
     * @param   \ROQUIN\RoqRedirect\Domain\Repository\RedirectRepository $redirectRepository
     * @return  NULL|\ROQUIN\RoqRedirect\Domain\Model\Redirect
     */
    public static function redirectAvailable($requestUrl, $domainRepository, $redirectRepository) {
        $redirect      = NULL;
        $requestDomain = $_SERVER['SERVER_NAME'];

        // Get the current domain record if exist
        $currentDomainRecord = $domainRepository->getCurrentDomain($requestDomain);

        // search for a matching redirect if the current domain exist
        if (is_array($currentDomainRecord)) {

            /** @var \ROQUIN\RoqRedirect\Domain\Model\Domain $domain */
            $domain = GeneralUtility::makeInstance(
                'ROQUIN\\RoqRedirect\\Domain\\Model\\Domain'
            );
            $domain->setPid($currentDomainRecord['pid']);
            $domain->setDomainName($currentDomainRecord['domainName']);

            // Get the current domain record if exist
            $redirectRecord = $redirectRepository->getRedirectByDomain($domain, $requestUrl);

            if (is_array($redirectRecord)) {

                /** @var \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect */
                $redirect = GeneralUtility::makeInstance(
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
     */
    public function redirectToInternalPage() {
        // Fake a TS FE Controller to use typolink url
        GeneralUtility::makeInstance(
            'ROQUIN\\RoqRedirect\\Utility\\FakeTypoScriptFrontendController'
        );

        // Create a typolink url
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter'        => (int)$this->getRedirectTo(),
                'additionalParams' => '&L=' . $this->getLanguageUid()
            )
        );

        // Add additional data to the typolink url for linking inside a html page
        if ($this->getAdditionalUrl()) {
            $url .= $this->getAdditionalUrl();
        }

        // Do the actual redirect
        Http::redirect($url, $this->getHttpCode());
    }

    /**
     * Redirect to
     *
     * @param   \ROQUIN\RoqRedirect\Domain\Repository\FileRepository $fileRepository
     */
    public function redirectToInternalFile($fileRepository) {
        // Get the file record by redirect
        $fileRecord = $fileRepository->getFileByRedirect($this);

        if (is_array($fileRecord)) {
            // Get the url of the file
            $url = File::getUrl($fileRecord);

            // Do the actual redirect
            Http::redirect($url, $this->getHttpCode());
        }
    }
}

?>