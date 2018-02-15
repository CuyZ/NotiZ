<?php
defined('TYPO3_MODE') or die();

$tableName = basename(__FILE__, '.php');

return \CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\TCA\EntitySlackTcaWriter::get()->getTcaArray($tableName);
