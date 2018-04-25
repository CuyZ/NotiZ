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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Core\Notification\Settings\NotificationSettings;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessor;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessorInterface;

class EntitySlackSettings extends AbstractDefinitionComponent implements NotificationSettings, DataPreProcessorInterface
{
    /**
     * @var \CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Bots\Bot[]
     */
    protected $bots;

    /**
     * @var \CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Channels\Channel[]
     */
    protected $channels;

    /**
     * @return Bots\Bot[]
     */
    public function getBots()
    {
        return $this->bots;
    }

    /**
     * @return Channels\Channel[]
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function hasChannel($identifier)
    {
        return isset($this->channels[$identifier]);
    }

    /**
     * @param string $identifier
     * @return Channels\Channel
     */
    public function getChannel($identifier)
    {
        if (!$this->hasChannel($identifier)) {
            throw EntryNotFoundException::entitySlackChannelDefinitionNotFound($identifier);
        }

        return $this->channels[$identifier];
    }

    /**
     * @param DataPreProcessor $processor
     */
    public static function dataPreProcessor(DataPreProcessor $processor)
    {
        $data = $processor->getData();

        // Bots object must always be set.
        if (!is_array($data['bots'])) {
            $data['bots'] = [];
        }

        // Channels object must always be set.
        if (!is_array($data['channels'])) {
            $data['channels'] = [];
        }

        $processor->setData($data);
    }
}
