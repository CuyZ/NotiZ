<?php

if (!defined('TYPO3_MODE')) {
    throw new \Exception('Access denied.');
}

\CuyZ\Notiz\Service\Extension\LocalConfigurationService::get()->process();
