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
use CuyZ\Notiz\Property\Service\MarkerParser;
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
     * @var Definition
     */
    protected $definition;

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
     * @param DefinitionService $definitionService
     * @param MarkerParser $markerParser
     */
    public function __construct(Payload $payload, DefinitionService $definitionService, MarkerParser $markerParser)
    {
        $this->notification = $payload->getNotification();
        $this->notificationSettings = $payload->getNotificationDefinition()->getSettings();

        $this->definition = $definitionService->getDefinition();
        $this->markerParser = $markerParser;

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
        $view->setPartialRootPaths($viewSettings->getPartialRootPaths());

        $view->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName('EXT:notiz/Resources/Private/Templates/Mail/Default.html')
        );

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
}
