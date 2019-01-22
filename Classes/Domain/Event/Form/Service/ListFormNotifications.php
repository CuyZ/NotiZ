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

namespace CuyZ\Notiz\Domain\Event\Form\Service;

use CuyZ\Notiz\Domain\Event\Form\DispatchFormNotificationFinisher;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;

class ListFormNotifications implements SingletonInterface
{
    /**
     * @var FormPersistenceManagerInterface
     */
    protected $formPersistenceManager;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        $this->formPersistenceManager = Container::get(FormPersistenceManagerInterface::class);
    }

    /**
     * Loops on every registered form definition and checks if it uses the
     * notification dispatch finisher. If it does, the identifier is fetched and
     * added to the list.
     *
     * @param array $parameters
     */
    public function doList(array &$parameters)
    {
        foreach ($this->formPersistenceManager->listForms() as $form) {
            $persistenceIdentifier = $form['persistenceIdentifier'];
            $formDefinition = $this->formPersistenceManager->load($persistenceIdentifier);
            $finishers = $formDefinition['finishers'] ?? [];

            foreach ($finishers as $finisher) {
                if ($finisher['identifier'] === DispatchFormNotificationFinisher::DISPATCH_NOTIFICATION) {
                    $parameters['items'][] = [
                        $formDefinition['label'] . ' (' . $persistenceIdentifier . ')',
                        $persistenceIdentifier,
                    ];
                }
            }
        }
    }
}
