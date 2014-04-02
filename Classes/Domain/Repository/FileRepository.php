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
class FileRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Get the file record by redirect object
     *
     * @param \ROQUIN\RoqRedirect\Domain\Model\Redirect $redirect
     * @return array|NULL
     */
    public function getFileByRedirect($redirect) {
        $fileRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
            'f.*',
            'sys_file as f, sys_file_reference as r',
            "r.tablenames = 'tx_roqredirect_domain_model_redirect'
            AND r.fieldname = 'internal_file'
            AND f.uid = r.uid_local
            AND r.hidden = 0
            AND r.deleted = 0
            AND r.uid_foreign = " . (int)$redirect->getId()
        );

        return $fileRecord;
    }
}

?>