<?php
defined('TYPO3_MODE') or die();

$tableName = basename(__FILE__, '.php');

return \CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\TCA\EntityLogTcaWriter::get()->getTcaArray($tableName);
