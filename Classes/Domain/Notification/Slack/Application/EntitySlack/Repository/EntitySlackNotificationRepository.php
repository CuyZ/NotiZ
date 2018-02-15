<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Repository;

use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification;
use CuyZ\Notiz\Domain\Repository\EntityNotificationRepository;

class EntitySlackNotificationRepository extends EntityNotificationRepository
{
    /**
     * Forces the object type handled by this repository
     */
    public function initializeObject()
    {
        $this->objectType = EntitySlackNotification::class;

        parent::initializeObject();
    }
}
