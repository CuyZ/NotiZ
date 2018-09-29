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

namespace CuyZ\Notiz\Core\Support;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class Url
{
    const DOCUMENTATION_ROOT = 'https://github.com/CuyZ/NotiZ/blob/%s/Documentation/Markdown/README.md#-notiz--documentation';
    const DOCUMENTATION_CREATE_CUSTOM_EVENT = 'https://github.com/CuyZ/NotiZ/blob/%s/Documentation/Markdown/Events/Create-a-custom-event.md#create-a-custom-event';
    const DOCUMENTATION_ADD_TYPOSCRIPT_DEFINITION = 'https://github.com/CuyZ/NotiZ/blob/%s/Documentation/Markdown/Developers/Add-TypoScript-definition.md#add-typoscript-definition';

    const REPOSITORY = 'https://github.com/CuyZ/NotiZ';
    const NEW_ISSUE = 'https://github.com/CuyZ/NotiZ/issues/new';

    const SLACK_CHANNEL = 'https://typo3.slack.com/messages/ext-notiz';

    /**
     * @return string
     */
    public static function documentation()
    {
        return self::build(self::DOCUMENTATION_ROOT);
    }

    /**
     * @return string
     */
    public static function documentationCreateCustomEvent()
    {
        return self::build(self::DOCUMENTATION_CREATE_CUSTOM_EVENT);
    }

    /**
     * @return string
     */
    public static function documentationTypoScriptDefinition()
    {
        return self::build(self::DOCUMENTATION_ADD_TYPOSCRIPT_DEFINITION);
    }

    /**
     * @return string
     */
    public static function repository()
    {
        return self::REPOSITORY;
    }

    /**
     * @return string
     */
    public static function newIssue()
    {
        return self::NEW_ISSUE;
    }

    /**
     * @return string
     */
    public static function slackChannel()
    {
        return self::SLACK_CHANNEL;
    }

    /**
     * @param string $url
     * @return string
     */
    private static function build($url)
    {
        return vsprintf(
            $url,
            [ExtensionManagementUtility::getExtensionVersion(NotizConstants::EXTENSION_KEY)]
        );
    }
}
