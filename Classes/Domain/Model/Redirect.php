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
class Redirect extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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

}
?>