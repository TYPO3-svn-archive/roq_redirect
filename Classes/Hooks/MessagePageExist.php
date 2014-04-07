<?php
namespace ROQUIN\RoqRedirect\Hooks;

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

use ROQUIN\RoqRedirect\Utility\Http;

/**
 * Hook into BE after managing redirects and check if the source of the redirect already exist
 *
 * @author Patrick Wiggelman <patrick@roquin.nl>
 * @package TYPO3
 * @subpackage roq_redirect
 */

class MessagePageExist
{

    /**
     * Hooks into TCE main before record is edit in the DB
     *
     * @param array   The field data of the record
     * @param string  The table the record belongs to
     * @param integer The record's uid
     * @param t3lib_TCEmain TYPO3 Core Engine parent object
     */
    public function processDatamap_preProcessFieldArray(&$fieldArray, $table, $uid, &$pObj) {
        if ($table == 'tx_roqredirect_domain_model_redirect' && (isset($GLOBALS['_POST']['_savedok_x'])
                OR isset($GLOBALS['_POST']['_savedokview_x'])
                OR isset($GLOBALS['_POST']['_saveandclosedok_x'])
                OR isset($GLOBALS['_POST']['_savedoknew_x'])) && !$GLOBALS['BE_USER']->workspace
        ) {

            // Fake a TS FE Controller with the page id to get the base url with GLOBALS
            \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                'ROQUIN\\RoqRedirect\\Utility\\FakeTypoScriptFrontendController',
                $GLOBALS['_POST']['popViewId']
            );

            // Get the base url
            if ($GLOBALS['TSFE']->tmpl->setup['config.']['baseURL']) {
                $url = $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'] . $fieldArray['redirect_url'];

                if (Http::urlAlreadyExist($url) == TRUE) {
                    $this->setFlashMessage(
                        $GLOBALS['LANG']->sL('LLL:EXT:roq_redirect/Resources/Private/Language/locallang.xlf:warning.head.urlAlreadyExist'),
                        $GLOBALS['LANG']->sL('LLL:EXT:roq_redirect/Resources/Private/Language/locallang.xlf:warning.messagePart1.urlAlreadyExist') .
                            $url . $GLOBALS['LANG']->sL('LLL:EXT:roq_redirect/Resources/Private/Language/locallang.xlf:warning.messagePart2.urlAlreadyExist'),
                        \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING
                    );
                };
            } else {
                $this->setFlashMessage(
                    $GLOBALS['LANG']->sL('LLL:EXT:roq_redirect/Resources/Private/Language/locallang.xlf:warning.head.noBaseUrl'),
                    $GLOBALS['LANG']->sL('LLL:EXT:roq_redirect/Resources/Private/Language/locallang.xlf:warning.message.noBaseUrl'),
                    \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING
                );
            }
        }
    }

    /**
     * Returns a flashmessage in the backend of TYPO3
     *
     * @param string $messageHeader   Message title
     * @param string $message         The message
     * @param string $type            Severiy
     */
    protected function setFlashMessage($messageHeader, $message, $type = \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING) {
        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            $message,
            $messageHeader,
            $type,
            TRUE
        );
        \TYPO3\CMS\Core\Messaging\FlashMessageQueue::addMessage($message);
        $message->render();
    }
}

?>