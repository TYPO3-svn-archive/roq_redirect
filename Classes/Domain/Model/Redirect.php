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
     * @var \int
     */
    protected $id;

    /**
     * redirectUrl
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $redirectUrl;

    /**
     * redirectTo
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $redirectTo;

    /**
     * httpCode
     *
     * @var \integer
     */
    protected $httpCode;

    /**
     * languageUid
     *
     * @var \int
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
     * @return \int $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the id
     *
     * @param \int $id
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns the redirectUrl
     *
     * @return \string $redirectUrl
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * Sets the redirectUrl
     *
     * @param \string $redirectUrl
     * @return void
     */
    public function setRedirectUrl($redirectUrl) {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns the redirectTo
     *
     * @return \string $redirectTo
     */
    public function getRedirectTo() {
        return $this->redirectTo;
    }

    /**
     * Sets the redirectTo
     *
     * @param \string $redirectTo
     * @return void
     */
    public function setRedirectTo($redirectTo) {
        $this->redirectTo = $redirectTo;
    }

    /**
     * Returns the httpCode
     *
     * @return \integer $httpCode
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * Sets the httpCode
     *
     * @param \integer $httpCode
     * @return void
     */
    public function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
    }

    /**
     * Returns the languageUid
     *
     * @return \int $languageUid
     */
    public function getLanguageUid() {
        return $this->languageUid;
    }

    /**
     * Sets the languageUid
     *
     * @param \int $languageUid
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
}

?>