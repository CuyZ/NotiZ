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

use CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\EntityLogNotification;
use CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\Service\EntityLogMessageBuilder;

class ShowEntityLogController extends ShowNotificationController
{
    /**
     * @var EntityLogNotification
     */
    protected $notification;

    /**
     * @inheritdoc
     */
    public function showAction()
    {
        parent::showAction();

        $this->view->assign('preview', $this->getPreview());
    }

    /**
     * Returns a preview of the shown log notification.
     *
     * @return string
     */
    protected function getPreview()
    {
        /** @var EntityLogMessageBuilder $entityLogMessageBuilder */
        $entityLogMessageBuilder = $this->objectManager->get(EntityLogMessageBuilder::class, $this->getPreviewPayload());

        return $entityLogMessageBuilder->getMessage();
    }

    /**
     * @return string
     */
    public function getNotificationDefinitionIdentifier()
    {
        return EntityLogNotification::getDefinitionIdentifier();
    }
}
