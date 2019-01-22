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

namespace CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\Service;

use CuyZ\Notiz\Core\Channel\Payload;
use CuyZ\Notiz\Core\Property\Factory\PropertyFactory;
use CuyZ\Notiz\Core\Property\Service\MarkerParser;
use CuyZ\Notiz\Domain\Notification\Log\LogNotification;
use CuyZ\Notiz\Domain\Property\Marker;

class EntityLogMessageBuilder
{
    /**
     * @var LogNotification
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
     * @param PropertyFactory $propertyFactory
     */
    public function __construct(Payload $payload, MarkerParser $markerParser, PropertyFactory $propertyFactory)
    {
        $this->notification = $payload->getNotification();
        $this->markerParser = $markerParser;

        $this->markers = $propertyFactory->getProperties(Marker::class, $payload->getEvent());
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->markerParser->replaceMarkers(
            $this->notification->getMessage(),
            $this->markers
        );
    }
}
