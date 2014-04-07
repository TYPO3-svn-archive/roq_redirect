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

use ROQUIN\RoqRedirect\Domain\Repository;
use ROQUIN\RoqRedirect\Domain\Model\Redirect;
use ROQUIN\RoqRedirect\Utility\Http;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package roq_redirect
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RedirectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    const INTERNAL_PAGE = 0;
    const EXTERNAL_URL  = 1;
    const INTERNAL_FILE = 2;

    /**
     * domainRepository
     *
     * @var \ROQUIN\RoqRedirect\Domain\Repository\DomainRepository
     * @inject
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
        $this->domainRepository   = new Repository\DomainRepository();
        $this->redirectRepository = new Repository\RedirectRepository();
        $this->fileRepository     = new Repository\FileRepository();
    }

    /**
     * Redirect if redirect record exist
     *
     */
    public function doRedirectIfExist() {
        $this->injectRepositories();

        // Get redirect if available
        $requestUrl = trim(GeneralUtility::getIndpEnv('TYPO3_SITE_SCRIPT'));
        $redirect = Redirect::redirectAvailable($requestUrl, $this->domainRepository, $this->redirectRepository);

        // Redirect available
        if ($redirect != NULL) {
            // Exclude requests with method head used for checking url
            if ($GLOBALS['_SERVER']['REQUEST_METHOD'] !== 'HEAD') {
                // Update the visited redirect with +1
                $this->redirectRepository->updateCounter($redirect);

                switch ($redirect->getType()) {
                    // Internal page
                    case self::INTERNAL_PAGE:
                        $redirect->redirectToInternalPage();
                        break;
                    // External url
                    case self::EXTERNAL_URL:
                        Http::redirect($redirect->getExternalUrl(), $redirect->getHttpCode());
                        break;
                    // Internal file
                    case self::INTERNAL_FILE:
                        $redirect->redirectToInternalFile($this->fileRepository);
                        break;
                }
            }
        }
    }
}

?>