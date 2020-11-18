<?php
declare(strict_types=1);

/*
 * Copyright (C)
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
    const DOCUMENTATION_ROOT = 'https://docs.typo3.org/p/cuyz/notiz/%s/en-us/';
    const DOCUMENTATION_CREATE_CUSTOM_EVENT = self::DOCUMENTATION_ROOT . '06-Administrator/02-CustomEvent/Index.html';
    const DOCUMENTATION_ADD_TYPOSCRIPT_DEFINITION = self::DOCUMENTATION_ROOT . '06-Administrator/01-Definition/02-AddFileDefinition.html';

    const REPOSITORY = 'https://github.com/CuyZ/NotiZ';
    const NEW_ISSUE = 'https://github.com/CuyZ/NotiZ/issues/new';

    const SLACK_CHANNEL = 'https://typo3.slack.com/messages/ext-notiz';

    /**
     * @return string
     */
    public static function documentation(): string
    {
        return self::build(self::DOCUMENTATION_ROOT);
    }

    /**
     * @return string
     */
    public static function documentationCreateCustomEvent(): string
    {
        return self::build(self::DOCUMENTATION_CREATE_CUSTOM_EVENT);
    }

    /**
     * @return string
     */
    public static function documentationTypoScriptDefinition(): string
    {
        return self::build(self::DOCUMENTATION_ADD_TYPOSCRIPT_DEFINITION);
    }

    /**
     * @return string
     */
    public static function repository(): string
    {
        return self::REPOSITORY;
    }

    /**
     * @return string
     */
    public static function newIssue(): string
    {
        return self::NEW_ISSUE;
    }

    /**
     * @return string
     */
    public static function slackChannel(): string
    {
        return self::SLACK_CHANNEL;
    }

    /**
     * @param string $url
     * @return string
     */
    private static function build(string $url): string
    {
        return vsprintf(
            $url,
            [ExtensionManagementUtility::getExtensionVersion(NotizConstants::EXTENSION_KEY)]
        );
    }
}
