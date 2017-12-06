<?php

namespace CuyZ\Notiz\Domain\Channel\Log;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Typo3LogChannel extends LogChannel
{
    /**
     * @return LoggerInterface
     */
    protected function getLoggerInstance()
    {
        /** @var Logger $logger */
        $logger = GeneralUtility::makeInstance(LogManager::class)
            ->getLogger(__CLASS__);

        return $logger;
    }
}
