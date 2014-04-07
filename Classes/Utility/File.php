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
 * Utility Class for File
 *
 * @author Patrick Wiggelman <patrick@roquin.nl>
 * @package TYPO3
 * @subpackage roq_redirect
 */

class File
{

    /**
     * Get the url of the file where it is located
     *
     * @param array $fileRecord
     * @return string   $fileUrl
     */
    public static function getUrl($fileRecord) {
        // Get the storage record of the file
        /** @var  $storageRecord */
        $storageRepository = new \ROQUIN\RoqRedirect\Domain\Repository\StorageRepository();
        $storageRecord     = $storageRepository->getStorageByFile($fileRecord);

        // Set the file url
        $storageBaseUrl = File::getStorageBaseUrl($storageRecord);
        $fileUrl        = $storageBaseUrl . ltrim($fileRecord['identifier'], '/');

        return $fileUrl;
    }

    /**
     * Get the base url of the storage (only for local driver)
     *
     * @param array $storageRecord
     * @return string
     */
    public static function getStorageBaseUrl($storageRecord) {
        // Get the storage record configuration from xml
        $configuration = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->convertFlexFormDataToConfigurationArray($storageRecord['configuration']);

        $absoluteBasePath = $configuration['basePath'];

        // Set the absolute base path
        if ($configuration['pathType'] === 'relative') {
            $absoluteBasePath = PATH_site . $absoluteBasePath;
        }

        // Set the base url of the storage
        if (\TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($absoluteBasePath, PATH_site)) {
            $baseUrl = substr($absoluteBasePath, strlen(PATH_site));
        } elseif (isset($configuration['baseUri']) && \TYPO3\CMS\Core\Utility\GeneralUtility::isValidUrl($configuration['baseUri'])) {
            $baseUrl = rtrim($configuration['baseUri'], '/') . '/';
        }

        return $baseUrl;
    }
}

?>