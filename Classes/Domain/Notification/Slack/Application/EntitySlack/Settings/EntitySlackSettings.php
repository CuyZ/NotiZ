<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
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
