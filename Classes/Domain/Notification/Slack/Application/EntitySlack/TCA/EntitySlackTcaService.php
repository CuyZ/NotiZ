<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\TCA;

use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;

class EntitySlackTcaService extends NotificationTcaService
{
    /**
     * @return string
     */
    protected function getNotificationIdentifier()
    {
        return 'entitySlack';
    }
}
