<?php
namespace ROQUIN\RoqRedirect\Domain\Repository;

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
class RedirectRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Get the redirect by request and domain
     *
     * @param   \ROQUIN\RoqRedirect\Domain\Model\Domain $domain
     * @param   string $requestUrl
     * @return array|NULL
     */
    public function getRedirectByDomain(\ROQUIN\RoqRedirect\Domain\Model\Domain $domain, $requestUrl) {
        $url = $GLOBALS['TYPO3_DB']->fullQuoteStr($requestUrl, 'tx_roqredirect_domain_model_redirect');

        $where = "pid = '" . (int)$domain->getPid() . "'
            AND redirect_url = " . $url . "
            AND deleted = 0 AND hidden = 0
            AND starttime <= '" . $GLOBALS['SIM_ACCESS_TIME'] . "'
            AND (endtime=0 OR endtime > '" . $GLOBALS['SIM_ACCESS_TIME'] . "')";

        $redirectRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
            '*',
            'tx_roqredirect_domain_model_redirect',
            $where
        );

        return $redirectRecord;
    }

    /**
     * Update the counter
     *
     * @param \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect
     * @return boolean
     */
    public function updateCounter($redirect) {
        $res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
            'tx_roqredirect_domain_model_redirect',
            "uid = " . (int)$redirect->getId(),
            array('counter' => 'counter + 1'),
            array('counter')
        );

        return $res;
    }
}

?>