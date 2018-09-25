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

namespace CuyZ\Notiz\Domain\Notification;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Core\Definition\Tree\Definition;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Definition\Tree\Notification\Channel\ChannelDefinition;
use CuyZ\Notiz\Core\Definition\Tree\Notification\NotificationDefinition;
use CuyZ\Notiz\Core\Notification\MultipleChannelsNotification;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\BackendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Service\FlexFormService;

abstract class EntityNotification extends AbstractEntity implements Notification, MultipleChannelsNotification
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $eventConfigurationFlex;

    /**
     * @var array
     */
    protected $eventConfiguration;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\BackendUser
     * @lazy
     */
    protected $backendUser;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param string $eventConfigurationFlex
     */
    public function setEventConfigurationFlex($eventConfigurationFlex)
    {
        $this->eventConfigurationFlex = $eventConfigurationFlex;
    }

    /**
     * @return NotificationDefinition
     */
    public function getNotificationDefinition()
    {
        return $this->getDefinition()->getNotification(static::getDefinitionIdentifier());
    }

    /**
     * @return EventDefinition
     */
    public function getEventDefinition()
    {
        return $this->getDefinition()->getEventFromFullIdentifier($this->getEvent());
    }

    /**
     * Returns the event configuration stored as a FlexForm string.
     *
     * @return array
     */
    public function getEventConfiguration()
    {
        if (null === $this->eventConfiguration) {
            /** @var FlexFormService $flexFormService */
            $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);

            $this->eventConfiguration = $flexFormService->convertFlexFormContentToArray($this->eventConfigurationFlex);
        }

        return $this->eventConfiguration;
    }

    /**
     * @return BackendUser
     */
    public function getBackendUser()
    {
        return $this->backendUser;
    }

    /**
     * @return bool
     */
    public static function isCreatable()
    {
        return Container::getBackendUser()
            && Container::getBackendUser()->check('tables_modify', self::getTableName());
    }

    /**
     * @param string $selectedEvent
     * @return string
     */
    public static function getCreationUri($selectedEvent = null)
    {
        $tableName = static::getTableName();

        $href = BackendUtility::getModuleUrl(
            'record_edit',
            [
                "edit[$tableName][0]" => 'new',
                'returnUrl' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
            ]
        );

        if ($selectedEvent) {
            $href .= "&selectedEvent=$selectedEvent";
        }

        return $href;
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        $backendUser = Container::getBackendUser();
        $page = Container::getPageRepository()->getPage($this->pid);
        $userPermissionOnPage = $backendUser->calcPerms($page);

        return $backendUser->recordEditAccessInternals(self::getTableName(), $this->uid)
            && ($this->pid === 0
                || (bool)($userPermissionOnPage & Permission::CONTENT_EDIT)
            );
    }

    /**
     * @return string
     */
    public function getEditionUri()
    {
        $identifier = $this->getNotificationDefinition()->getIdentifier();
        $tableName = static::getTableName();
        $uid = $this->getUid();

        return BackendUtility::getModuleUrl(
            'record_edit',
            [
                "edit[$tableName][$uid]" => 'edit',
                'returnUrl' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL') . "#$identifier-$uid",
            ]
        );
    }

    /**
     * @return bool
     */
    public static function isListable()
    {
        return Container::getBackendUser()
            && Container::getBackendUser()->check('tables_select', self::getTableName());
    }

    /**
     * @return bool
     */
    public function isViewable()
    {
        return self::isListable();
    }

    /**
     * @return string
     */
    public function getViewUri()
    {
        $notificationDefinition = $this->getNotificationDefinition();

        $controller = 'Backend\\Manager\\Notification\\Show' . ucfirst($notificationDefinition->getIdentifier());

        $indexModuleHandler = Container::get(IndexModuleHandler::class);

        return $indexModuleHandler
            ->getUriBuilder()
            ->forController($controller)
            ->forAction('show')
            ->withArguments(['notificationIdentifier' => $this->getUid()])
            ->build();
    }

    /**
     * The selected channel is stored in the `$channel` property.
     *
     * @inheritdoc
     */
    public function shouldDispatch(ChannelDefinition $definition)
    {
        return $definition->getClassName() === $this->getChannel();
    }

    /**
     * Returns the name of the table for this notification. It is fetched in the
     * global TypoScript configuration.
     *
     * @return string
     */
    public static function getTableName()
    {
        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = Container::get(ConfigurationManagerInterface::class);
        $configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $className = self::getDefinition()
            ->getNotification(static::getDefinitionIdentifier())
            ->getClassName();

        return ArrayUtility::getValueByPath($configuration, "persistence/classes/$className/mapping/tableName");
    }

    /**
     * @return string
     */
    abstract public static function getDefinitionIdentifier();

    /**
     * @return Definition
     */
    protected static function getDefinition()
    {
        return DefinitionService::get()->getDefinition();
    }
}
