<?php
defined('TYPO3_MODE') or die();

$tableName = basename(__FILE__, '.php');

return \CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\TCA\EntityEmailTcaWriter::get()->getTcaArray($tableName);
