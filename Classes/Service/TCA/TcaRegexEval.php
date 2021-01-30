<?php
declare(strict_types=1);

/*
 * Copyright (C)
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\Service\TCA;

use CuyZ\Notiz\Service\LocalizationService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function preg_last_error;
use function preg_match;

final class TcaRegexEval implements SingletonInterface
{
    /**
     * Will check if the given value has a correct regex syntax. Sends a flash
     * message and resets the value if not.
     *
     * @param string $value
     * @return string
     */
    public function evaluateFieldValue($value)
    {
        if (empty($value)) {
            return $value;
        }

        preg_match($value, '');

        if (preg_last_error() === PREG_NO_ERROR) {
            return $value;
        }

        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            LocalizationService::localize('Backend/TCA:regex_error.description', [$value]),
            LocalizationService::localize('Backend/TCA:regex_error.title'),
            FlashMessage::ERROR
        );

        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        return '';
    }
}
