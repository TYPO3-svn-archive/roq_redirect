<?php
namespace ROQUIN\RoqRedirect\Utility;

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
 * Utility Class for Http
 *
 * @author Patrick Wiggelman <patrick@roquin.nl>
 * @package TYPO3
 * @subpackage roq_redirect
 */

class Http {

    const HTTP_STATUS_301 = 'HTTP/1.1 301 Moved Permanently';
    const HTTP_STATUS_302 = 'HTTP/1.1 302 Found';
    const HTTP_STATUS_303 = 'HTTP/1.1 303 See Other';
    const HTTP_STATUS_307 = 'HTTP/1.1 307 Temporary Redirect';

    /**
     * Get the HTTP Status
     *
     * @param int $httpStatus
     * return string $httpStatus
     */
    public static function getHttpStatus($httpStatus = 301) {
        switch ($httpStatus) {
            case 301:
                $httpStatus = self::HTTP_STATUS_301;
                break;
            case 302:
                $httpStatus = self::HTTP_STATUS_302;
                break;
            case 303:
                $httpStatus = self::HTTP_STATUS_303;
                break;
            case 307:
                $httpStatus = self::HTTP_STATUS_307;
                break;
        }

        return $httpStatus;
    }

}

?>