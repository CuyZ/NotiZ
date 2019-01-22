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

namespace CuyZ\Notiz\Core\Definition\Tree\Notification;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use CuyZ\Notiz\Core\Definition\Tree\Notification\Channel\ChannelDefinition;
use CuyZ\Notiz\Core\Exception\ClassNotFoundException;
use CuyZ\Notiz\Core\Exception\InvalidClassException;
use CuyZ\Notiz\Core\Exception\NotizException;
use CuyZ\Notiz\Core\Notification\CustomSettingsNotification;
use CuyZ\Notiz\Core\Notification\Processor\NotificationProcessor;
use CuyZ\Notiz\Core\Notification\Processor\NotificationProcessorFactory;
use CuyZ\Notiz\Core\Notification\Settings\NotificationSettings;
use CuyZ\Notiz\Core\Notification\Viewable;
use CuyZ\Notiz\Core\Support\NotizConstants;
use CuyZ\Notiz\Service\IconService;
use CuyZ\Notiz\Service\LocalizationService;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessor;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessorInterface;
use TYPO3\CMS\Extbase\Error\Error;

class NotificationDefinition extends AbstractDefinitionComponent implements DataPreProcessorInterface
{
    const DEFAULT_ICON_PATH = NotizConstants::EXTENSION_ICON_DEFAULT;

    /**
     * @var string
     *
     * @validate NotEmpty
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     *
     * @validate NotEmpty
     * @validate Romm.ConfigurationObject:ClassImplements(interface=CuyZ\Notiz\Core\Notification\Notification)
     */
    protected $className;

    /**
     * @var NotificationSettings
     *
     * @mixedTypesResolver \CuyZ\Notiz\Core\Definition\Tree\Notification\Settings\NotificationSettingsResolver
     */
    protected $settings;

    /**
     * @var \CuyZ\Notiz\Core\Definition\Tree\Notification\Channel\ChannelDefinition[]
     *
     * @validate NotEmpty
     */
    protected $channels = [];

    /**
     * @var string
     *
     * @validate Romm.ConfigurationObject:FileExists
     */
    protected $iconPath;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label
            ? LocalizationService::localize($this->label)
            : $this->identifier;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return LocalizationService::localize($this->description);
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return NotificationSettings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @return ChannelDefinition[]
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @return string
     */
    public function getIconPath()
    {
        return $this->iconPath ?: self::DEFAULT_ICON_PATH;
    }

    /**
     * The icon will be registered in the TYPO3 icon registry, using the icon
     * path.
     *
     * @return string
     */
    public function getIconIdentifier()
    {
        return IconService::get()->registerNotificationIcon($this);
    }

    /**
     * @return NotificationProcessor
     */
    public function getProcessor()
    {
        return NotificationProcessorFactory::get()->getFromNotificationClassName($this->getClassName());
    }

    /**
     * @return bool
     */
    public function isListable()
    {
        /** @var Viewable $className */
        $className = $this->getClassName();

        return \in_array(Viewable::class, \class_implements($className))
            && $className::isListable();
    }

    /**
     * Method called during the definition object construction: it allows
     * manipulating the data array before it is actually used to construct the
     * object.
     *
     * We use it to:
     *
     * - Automatically fill the `identifier` property of the channels with the
     *   keys of the array.
     * - Add the settings class name further in the data array so it can be
     *   fetched later.
     *
     * @param DataPreProcessor $processor
     */
    public static function dataPreProcessor(DataPreProcessor $processor)
    {
        self::forceIdentifierForProperty($processor, 'channels');

        $data = $processor->getData();

        // Settings must always be set.
        if (!is_array($data['settings'])) {
            $data['settings'] = [];
        }

        $data['settings'][NotificationSettings::SETTINGS_CLASS_NAME] = NotificationSettings::TYPE_DEFAULT;

        try {
            $data = self::fetchSettingsClassName($data);
        } catch (NotizException $exception) {
            $error = new Error($exception->getMessage(), $exception->getCode());
            $processor->addError($error);
        }

        $processor->setData($data);
    }

    /**
     * @param array $data
     * @return array
     *
     * @throws ClassNotFoundException
     * @throws InvalidClassException
     */
    protected static function fetchSettingsClassName(array $data)
    {
        $notificationClassName = $data['className'] ?? null;

        if (class_exists($notificationClassName)
            && in_array(CustomSettingsNotification::class, class_implements($notificationClassName))
        ) {
            /** @var CustomSettingsNotification $notificationClassName */
            $settingsClassName = $notificationClassName::getSettingsClassName();

            if (!class_exists($settingsClassName)) {
                throw ClassNotFoundException::notificationSettingsClassNotFound($settingsClassName);
            }

            if (!in_array(NotificationSettings::class, class_implements($settingsClassName))) {
                throw InvalidClassException::notificationSettingsMissingInterface($settingsClassName);
            }

            $data['settings'][NotificationSettings::SETTINGS_CLASS_NAME] = $settingsClassName;
        }

        return $data;
    }
}
