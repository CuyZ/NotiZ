<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Channels;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;

class Channel extends AbstractDefinitionComponent
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $webhookUrl;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getWebhookUrl()
    {
        return $this->webhookUrl;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
