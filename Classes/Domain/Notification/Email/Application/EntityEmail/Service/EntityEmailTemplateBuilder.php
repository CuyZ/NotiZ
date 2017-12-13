<?php

/*
 * Copyright (C) 2017
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

namespace CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Service;

use CuyZ\Notiz\Channel\Payload;
use CuyZ\Notiz\Definition\DefinitionService;
use CuyZ\Notiz\Definition\Tree\Definition;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\EntityEmailNotification;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Settings\EntityEmailSettings;
use CuyZ\Notiz\Domain\Property\Marker;
use CuyZ\Notiz\Event\Event;
use CuyZ\Notiz\Property\Service\MarkerParser;
use CuyZ\Notiz\Service\StringService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class EntityEmailTemplateBuilder
{
    /**
     * @var EntityEmailNotification
     */
    protected $notification;

    /**
     * @var EntityEmailSettings
     */
    protected $notificationSettings;

    /**
     * @var Event
     */
    protected $event;

    /**
     * @var Definition
     */
    protected $definition;

    /**
     * @var MarkerParser
     */
    protected $markerParser;

    /**
     * @var StringService
     */
    protected $stringService;

    /**
     * @var Marker[]
     */
    protected $markers = [];

    /**
     * @param Payload $payload
     * @param DefinitionService $definitionService
     * @param MarkerParser $markerParser
     * @param StringService $stringService
     */
    public function __construct(Payload $payload, DefinitionService $definitionService, MarkerParser $markerParser, StringService $stringService)
    {
        $this->notification = $payload->getNotification();
        $this->notificationSettings = $payload->getNotificationDefinition()->getSettings();

        $this->event = $payload->getEvent();

        $this->definition = $definitionService->getDefinition();
        $this->markerParser = $markerParser;
        $this->stringService = $stringService;

        $this->markers = $payload->getEvent()->getProperties(Marker::class);
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->markerParser->replaceMarkers(
            $this->notification->getSubject(),
            $this->markers
        );
    }

    /**
     * @return string
     */
    public function getBody()
    {
        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);

        $viewSettings = $this->notificationSettings->getView();

        $view->setLayoutRootPaths($viewSettings->getLayoutRootPaths());
        $view->setTemplateRootPaths($viewSettings->getTemplateRootPaths());
        $view->setPartialRootPaths($viewSettings->getPartialRootPaths());

        $view->setTemplate($this->getTemplatePath());
        
        if (!$view->hasTemplate()) {
            $view->setTemplate('Default');
        }

        $layout = $viewSettings->getLayout($this->notification->getLayout());

        $body = $this->markerParser->replaceMarkers(
            $this->notification->getBody(),
            $this->markers
        );

        $view->assign('body', $body);
        $view->assign('layout', $layout->getPath());
        $view->assign('markers', $this->markers);

        return $view->render();
    }

    /**
     * Returns the calculated template path, based on the identifiers of both
     * the dispatched event and its group. The identifiers will be sanitized to
     * match the UpperCamelCase format.
     *
     * For instance, the template path for the event `myEvent` from the group
     * `my_company` will be located at `MyCompany/MyEvent.html`.
     *
     * @return string
     */
    protected function getTemplatePath()
    {
        $eventDefinition = $this->event->getDefinition();

        $groupPath = $this->stringService->upperCamelCase($eventDefinition->getGroup()->getIdentifier());
        $eventPath = $this->stringService->upperCamelCase($eventDefinition->getIdentifier());

        return "$groupPath/$eventPath";
    }
}
