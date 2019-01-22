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

namespace CuyZ\Notiz\Core\Exception;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\Hook;

class ClassNotFoundException extends NotizException
{
    const DEFINITION_SOURCE_CLASS_NOT_FOUND = 'The definition source class `%s` was not found.';

    const DEFINITION_PROCESSOR_CLASS_NOT_FOUND = 'The definition processor class `%s` was not found.';

    const EVENT_CLASS_NOT_FOUND = 'The event class `%s` was not found.';

    const TAG_SERVICE_PROPERTY_CLASS_NOT_FOUND = 'Trying to set an identifier (value: `%s`) for a property whose class was not found: `%s`.';

    const NOTIFICATION_CLASS_NOT_FOUND = 'The notification class `%s` was not found.';

    const NOTIFICATION_PROCESSOR_CLASS_NOT_FOUND = 'The processor class `%s` for the notification `%s` was not found.';

    const NOTIFICATION_SETTINGS_CLASS_NOT_FOUND = 'The notification settings class `%s` was not found.';

    const EVENT_HOOK_INTERFACE_NOT_FOUND = 'The interface `%s` was not found (used in the hook connection at the path `%s`).';

    const EVENT_CONFIGURATION_FLEX_FORM_PROVIDER_CLASS_NOT_FOUND = 'The FlexForm provider class name `%s` was not found.';

    const CHANNEL_SETTINGS_CLASS_NOT_FOUND = 'The channel settings class `%s` was not found.';

    /**
     * @param string $className
     * @return self
     */
    public static function definitionSourceClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::DEFINITION_SOURCE_CLASS_NOT_FOUND,
            1503849399,
            [$className]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function definitionProcessorClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::DEFINITION_PROCESSOR_CLASS_NOT_FOUND,
            1503849990,
            [$className]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function eventClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::EVENT_CLASS_NOT_FOUND,
            1503873178,
            [$className]
        );
    }

    /**
     * @param string $propertyType
     * @param string $identifier
     * @return self
     */
    public static function tagServicePropertyClassNotFound(string $propertyType, string $identifier): self
    {
        return self::makeNewInstance(
            self::TAG_SERVICE_PROPERTY_CLASS_NOT_FOUND,
            1504167128,
            [$identifier, $propertyType]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function notificationClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::NOTIFICATION_CLASS_NOT_FOUND,
            1505821147,
            [$className]
        );
    }

    /**
     * @param string $notificationClassName
     * @param string $processorClassName
     * @return self
     */
    public static function notificationProcessorClassNotFound(string $notificationClassName, string $processorClassName): self
    {
        return self::makeNewInstance(
            self::NOTIFICATION_PROCESSOR_CLASS_NOT_FOUND,
            1505829871,
            [$processorClassName, $notificationClassName]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function notificationSettingsClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::NOTIFICATION_SETTINGS_CLASS_NOT_FOUND,
            1506245086,
            [$className]
        );
    }

    /**
     * @param string $interface
     * @param Hook $hook
     * @return self
     */
    public static function eventHookInterfaceNotFound(string $interface, Hook $hook): self
    {
        return self::makeNewInstance(
            self::EVENT_HOOK_INTERFACE_NOT_FOUND,
            1506800274,
            [
                $interface,
                $hook->getPath()
            ]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function eventConfigurationFlexFormProviderClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::EVENT_CONFIGURATION_FLEX_FORM_PROVIDER_CLASS_NOT_FOUND,
            1506952128,
            [$className]
        );
    }

    /**
     * @param string $className
     * @return self
     */
    public static function channelSettingsClassNotFound(string $className): self
    {
        return self::makeNewInstance(
            self::CHANNEL_SETTINGS_CLASS_NOT_FOUND,
            1507409137,
            [$className]
        );
    }
}
