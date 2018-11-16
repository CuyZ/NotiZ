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

use CuyZ\Notiz\Controller\Backend\Manager\ManagerController;
use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Channel\Payload;
use CuyZ\Notiz\Core\Definition\Tree\Notification\NotificationDefinition;
use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Event\Service\EventFactory;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Factory\PropertyContainer;
use CuyZ\Notiz\Core\Property\Factory\PropertyFactory;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

abstract class ShowNotificationController extends ManagerController
{
    /**
     * @var NotificationDefinition
     */
    protected $notificationDefinition;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var EventFactory
     */
    protected $eventFactory;

    /**
     * @param ViewInterface $view
     */
    public function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);

        $this->fetchNotification();

        $this->view->assign('notificationDefinition', $this->notificationDefinition);
        $this->view->assign('notification', $this->notification);
    }

    /**
     * Main action that will show details for the current notification entry.
     */
    public function showAction()
    {
        if (!$this->notification) {
            $this->addErrorMessage(
                'Backend/Module/Manager:list_notifications.notification_not_found',
                $this->notificationDefinition->getLabel(),
                $this->request->getArgument('notificationIdentifier')
            );


            $this->forward(
                'process',
                'Backend\\Manager\\ListNotifications',
                null,
                ['notificationIdentifier' => $this->notificationDefinition->getIdentifier()]
            );
        }
    }

    /**
     * @return string
     */
    abstract public function getNotificationDefinitionIdentifier();

    /**
     * Checks that an argument `notificationIdentifier` exists for the request,
     * and fetches the correct notification entry.
     */
    protected function fetchNotification()
    {
        $definition = $this->getDefinition();
        $notificationDefinitionIdentifier = $this->getNotificationDefinitionIdentifier();

        if (!$definition->hasNotification($notificationDefinitionIdentifier)) {
            $this->addErrorMessage(
                'Backend/Module/Manager:list_notifications.notification_type_not_found',
                $notificationDefinitionIdentifier
            );

            $this->forward('process', 'Backend\\Manager\\ListNotificationTypes');
        }

        $this->notificationDefinition = $definition->getNotification($notificationDefinitionIdentifier);

        if ($this->request->hasArgument('notificationIdentifier')) {
            $notificationIdentifier = $this->request->getArgument('notificationIdentifier');

            $this->notification = $this->notificationDefinition->getProcessor()->getNotificationFromIdentifier($notificationIdentifier);
        }
    }

    /**
     * @return Payload
     */
    protected function getPreviewPayload()
    {
        $fakeEvent = $this->eventFactory->create($this->notification->getEventDefinition(), $this->notification);

        if ($fakeEvent instanceof ProvidesExampleProperties) {
            $this->signalSlotDispatcher->connect(
                PropertyFactory::class,
                PropertyFactory::SIGNAL_PROPERTY_FILLING,
                function (PropertyContainer $container, Event $event) use ($fakeEvent) {
                    if ($event !== $fakeEvent) {
                        return;
                    }

                    $exampleProperties = $fakeEvent->getExampleProperties();

                    foreach ($container->getEntries() as $property) {
                        if (isset($exampleProperties[$property->getName()])) {
                            $property->setValue($exampleProperties[$property->getName()]);
                        }
                    }
                }
            );
        }

        return new Payload($this->notification, $this->notificationDefinition, $fakeEvent);
    }

    /**
     * @param EventFactory $eventFactory
     */
    public function injectEventFactory(EventFactory $eventFactory)
    {
        $this->eventFactory = $eventFactory;
    }

    /**
     * @return string
     */
    protected function getMenu()
    {
        return Menu::MANAGER_NOTIFICATIONS;
    }
}
