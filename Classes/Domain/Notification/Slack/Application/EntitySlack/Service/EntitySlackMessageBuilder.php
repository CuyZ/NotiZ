<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Service;

use CuyZ\Notiz\Core\Channel\Payload;
use CuyZ\Notiz\Core\Property\Service\MarkerParser;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;
use CuyZ\Notiz\Domain\Property\Marker;

class EntitySlackMessageBuilder
{
    /**
     * @var SlackNotification
     */
    protected $notification;

    /**
     * @var MarkerParser
     */
    protected $markerParser;

    /**
     * @var Marker[]
     */
    protected $markers = [];

    /**
     * @param Payload $payload
     * @param MarkerParser $markerParser
     */
    public function __construct(Payload $payload, MarkerParser $markerParser)
    {
        $this->notification = $payload->getNotification();
        $this->markerParser = $markerParser;

        $this->markers = $payload->getEvent()->getProperties(Marker::class);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->markerParser->replaceMarkers(
            $this->notification->getMessage(),
            $this->markers
        );
    }
}
