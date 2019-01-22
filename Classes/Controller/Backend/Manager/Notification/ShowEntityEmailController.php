<?php
declare(strict_types=1);

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

use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\EntityEmailNotification;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Service\EntityEmailTemplateBuilder;
use CuyZ\Notiz\Domain\Property\Email;
use Throwable;

class ShowEntityEmailController extends ShowNotificationController
{
    /**
     * @var EntityEmailNotification
     */
    protected $notification;

    /**
     * @inheritdoc
     */
    public function showAction()
    {
        parent::showAction();

        if ($this->notification->hasEventDefinition()) {
            $eventDefinition = $this->notification->getEventDefinition();
            $emailProperties = $eventDefinition->getPropertyDefinition(Email::class, $this->notification);

            $this->view->assign('emailProperties', $emailProperties);
        }
    }

    /**
     * This action is called to show a preview of the shown email notification.
     *
     * An event is simulated in order to render the original Fluid template used
     * by the notification. Example values may be added to simulate fake markers
     * in the view.
     *
     * @return string|null [PHP 7.1]
     */
    public function previewAction()
    {
        try {
            return $this->getEmailPreview();
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * This action is used to show an error
     */
    public function previewErrorAction()
    {
        return $this->getEmailPreview();
    }

    /**
     * @return string
     */
    protected function getEmailPreview(): string
    {
        if (!$this->notification->hasEventDefinition()) {
            return $this->notification->getBody();
        }

        /** @var EntityEmailTemplateBuilder $entityEmailTemplateBuilder */
        $entityEmailTemplateBuilder = $this->objectManager->get(EntityEmailTemplateBuilder::class, $this->getPreviewPayload());

        return $entityEmailTemplateBuilder->getBody();
    }

    /**
     * @return string
     */
    public function getNotificationDefinitionIdentifier(): string
    {
        return EntityEmailNotification::getDefinitionIdentifier();
    }
}
