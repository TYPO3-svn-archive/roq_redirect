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

/**
 *
 *
 * @package roq_redirect
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DomainController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * domainRepository
     *
     * @var \ROQUIN\RoqRedirect\Domain\Repository\DomainRepository
     * @inject
     */
    protected $domainRepository;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $authorizedDomains = array();
        $selectedDomain    = NULL;

        $arguments = $this->request->getArguments();
        $domains   = $this->domainRepository->findRedirectDomains();

        // Get authorized domains
        foreach ($domains->toArray() as $domain) {
            if (isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER']->isInWebMount($domain->getPid())) {
                $authorizedDomains[] = $domain;
            }
        }

        // Set the selected domain
        if ($arguments['domain']) {
            $selectedDomain = $this->domainRepository->findByUid((int)$arguments['domain']);
        } else {
            if (sizeof($authorizedDomains) > 0) {
                $selectedDomain = $authorizedDomains[0];
            }
        }

        $this->view->assign('domains', $authorizedDomains);
        $this->view->assign('selectedDomain', $selectedDomain);
    }
}

?>