<?php
namespace ROQUIN\RoqRedirect\Utility;

    /***************************************************************
     * Copyright notice
     *
     * (c) 2014 Patrick Wiggelman <patrick@roquin.nl>
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

class Http
{

    const HTTP_STATUS_301 = 'HTTP/1.1 301 Moved Permanently';
    const HTTP_STATUS_302 = 'HTTP/1.1 302 Found';
    const HTTP_STATUS_303 = 'HTTP/1.1 303 See Other';
    const HTTP_STATUS_307 = 'HTTP/1.1 307 Temporary Redirect';

    const HTTP_STATUS_OK = 200;

    /**
     * Get the HTTP Status
     *
     * @param int $httpStatusCode
     * @return string $httpStatus
     */
    public static function getHttpStatus($httpStatusCode = 301) {
        $httpStatusArray = array(
            301 => self::HTTP_STATUS_301,
            302 => self::HTTP_STATUS_302,
            303 => self::HTTP_STATUS_303,
            307 => self::HTTP_STATUS_307
        );

        return $httpStatusArray[$httpStatusCode];
    }

    /**
     * Redirect
     *
     * @param   string $url
     * @param   string $httpStatus
     */
    public static function redirect($url, $httpStatus = self::HTTP_STATUS_301) {
        header(Http::getHttpStatus($httpStatus));
        header('Location: ' . \TYPO3\CMS\Core\Utility\GeneralUtility::locationHeaderUrl($url));
        exit();
    }

    /**
     * Check if url already exist
     *
     * @param $url
     * @return bool
     */
    public static  function urlAlreadyExist($url) {
        // Setup curl for request with only headers
        $curlHandle = curl_init($url);
        curl_setopt($curlHandle, CURLOPT_NOBODY, true);
        curl_exec($curlHandle);
        $code = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);

        // Check if http code is ok
        if ($code == self::HTTP_STATUS_OK) {
            $status = true;
        } else {
            $status = false;
        }

        curl_close($curlHandle);

        return $status;
    }
}

?>