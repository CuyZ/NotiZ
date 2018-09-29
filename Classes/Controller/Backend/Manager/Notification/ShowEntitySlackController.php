<?php

/*
 * Copyright (C) 2018
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

namespace CuyZ\Notiz\Controller\Backend\Manager\Notification;

use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Service\EntitySlackMessageBuilder;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;

class ShowEntitySlackController extends ShowNotificationController
{
    /**
     * @var SlackNotification
     */
    protected $notification;

    /**
     * @inheritdoc
     */
    public function showAction()
    {
        parent::showAction();

        $message = $this->notification->getMessage();

        if ($this->notification->hasEventDefinition()) {
            $payload = $this->getPreviewPayload();

            if ($payload->getEvent() instanceof ProvidesExampleProperties) {
                $builder = $this->objectManager->get(EntitySlackMessageBuilder::class, $payload);
                $message = $builder->getMessage();
            }
        }

        $this->view->assign('message', $message);
    }

    /**
     * @return string
     */
    public function getNotificationDefinitionIdentifier()
    {
        return EntitySlackNotification::getDefinitionIdentifier();
    }
}
