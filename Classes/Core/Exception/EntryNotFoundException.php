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

namespace CuyZ\Notiz\Core\Exception;

use CuyZ\Notiz\Core\Definition\Tree\Definition;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\EventGroup;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Settings\View\Layout;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Channels\Channel;

class EntryNotFoundException extends NotizException
{
    const DEFINITION_SOURCE_NOT_FOUND = 'The definition source `%s` was not registered yet.';

    const DEFINITION_PROCESSOR_NOT_FOUND = 'The definition processor `%s` was not registered yet.';

    const DEFINITION_EVENT_GROUP_NOT_FOUND = 'The event group `%s` was not found, please use method `%s::hasEventGroup()`.';

    const DEFINITION_EVENT_NOT_FOUND = 'The event `%s` was not found, please use method `%s::hasEvent()`.';

    const DEFINITION_EVENT_FULL_IDENTIFIER_NOT_FOUND = 'The event with a full identifier `%s` was not found.';

    const DEFINITION_NOTIFICATION_NOT_FOUND = 'The notification `%s` was not found, please use method `%s::hasNotification()`.';

    const ENTITY_EMAIL_VIEW_LAYOUT_NOT_FOUND = 'The view layout `%s` was not found, please use method `%s::hasLayout()`.';

    const PROPERTY_ENTRY_NOT_FOUND = 'The property `%s` for the event `%s` does not have an entry `%s`, please use method `%s::hasEntry()`.';

    const EXTENSION_CONFIGURATION_ENTRY_NOT_FOUND = 'The entry `%s` was not found in the extension configuration.';

    const EVENT_RUNNER_ENTRY_NOT_FOUND = 'The runner entry `%s` was not found, please use method `%s::has()`.';

    const EVENT_CONNECTION_TYPE_MISSING = 'The property `type` must be filled with one of these values: `%s`.';

    const ENTITY_SLACK_BOT_NOT_FOUND = 'The Slack bot `%s` was not found.';

    const ENTITY_SLACK_CHANNEL_DEFINITION_NOT_FOUND = 'The channel definition `%s` was not found, please use method `%s::hasChannel()`.';

    /**
     * @param string $identifier
     * @return self
     */
    public static function definitionSourceNotFound($identifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_SOURCE_NOT_FOUND,
            1503849730,
            [$identifier]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function definitionProcessorNotFound($identifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_PROCESSOR_NOT_FOUND,
            1503850164,
            [$identifier]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function definitionEventGroupNotFound($identifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_EVENT_GROUP_NOT_FOUND,
            1503851646,
            [$identifier, Definition::class]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function definitionEventNotFound($identifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_EVENT_NOT_FOUND,
            1503851804,
            [$identifier, EventGroup::class]
        );
    }

    /**
     * @param string $fullIdentifier
     * @return self
     */
    public static function definitionEventFullIdentifierNotFound($fullIdentifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_EVENT_FULL_IDENTIFIER_NOT_FOUND,
            1520251011,
            [$fullIdentifier]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function definitionNotificationNotFound($identifier)
    {
        return self::makeNewInstance(
            self::DEFINITION_NOTIFICATION_NOT_FOUND,
            1510506078,
            [$identifier, Definition::class]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function entityEmailViewLayoutNotFound($identifier)
    {
        return self::makeNewInstance(
            self::ENTITY_EMAIL_VIEW_LAYOUT_NOT_FOUND,
            1503851908,
            [$identifier, Layout::class]
        );
    }

    /**
     * @param string $name
     * @param string $eventClassName
     * @param string $propertyType
     * @param object $object
     * @return self
     */
    public static function propertyEntryNotFound($name, $eventClassName, $propertyType, $object)
    {
        return self::makeNewInstance(
            self::PROPERTY_ENTRY_NOT_FOUND,
            1504104832,
            [$propertyType, $eventClassName, $name, get_class($object)]
        );
    }

    /**
     * @param string $key
     * @return self
     */
    public static function extensionConfigurationEntryNotFound($key)
    {
        return self::makeNewInstance(
            self::EXTENSION_CONFIGURATION_ENTRY_NOT_FOUND,
            1506239859,
            [$key]
        );
    }

    /**
     * @param string $key
     * @return self
     */
    public static function eventRunnerEntryNotFound($key)
    {
        return self::makeNewInstance(
            self::EVENT_RUNNER_ENTRY_NOT_FOUND,
            1506246269,
            [$key]
        );
    }

    /**
     * @param array $allowedTypes
     * @return self
     */
    public static function eventConnectionTypeMissing(array $allowedTypes)
    {
        return self::makeNewInstance(
            self::EVENT_CONNECTION_TYPE_MISSING,
            1509630193,
            [implode('`, `', $allowedTypes)]
        );
    }

    /**
     * @param string $botIdentifier
     * @return self
     */
    public static function entitySlackBotNotFound($botIdentifier)
    {
        return self::makeNewInstance(
            self::ENTITY_SLACK_BOT_NOT_FOUND,
            1519770222,
            [$botIdentifier]
        );
    }

    /**
     * @param string $identifier
     * @return self
     */
    public static function entitySlackChannelDefinitionNotFound($identifier)
    {
        return self::makeNewInstance(
            self::ENTITY_SLACK_CHANNEL_DEFINITION_NOT_FOUND,
            1524661834,
            [$identifier, Channel::class]
        );
    }
}
