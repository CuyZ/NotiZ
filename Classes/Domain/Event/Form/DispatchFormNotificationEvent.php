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

namespace CuyZ\Notiz\Domain\Event\Form;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use CuyZ\Notiz\Core\Property\Factory\PropertyContainer;
use CuyZ\Notiz\Domain\Property\Email;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Form\Domain\Finishers\FinisherContext;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;

/**
 * This event is triggered when a form that implements the notification dispatch
 * finisher is submitted.
 *
 * The identifier configured in the finisher must be the same as the identifier
 * in this event options, or the event is canceled.
 */
class DispatchFormNotificationEvent extends AbstractEvent implements ProvidesExampleProperties
{
    /**
     * @label Event/Form:dispatch_form_notification.marker.form_values
     * @marker
     *
     * @var array
     */
    protected $formValues;

    /**
     * @label Event/Form:dispatch_form_notification.marker.form_runtime
     * @marker
     *
     * @var FormRuntime
     */
    protected $formRuntime;

    /**
     * @label Event/Form:dispatch_form_notification.marker.controller_context
     * @marker
     *
     * @var ControllerContext
     */
    protected $controllerContext;

    /**
     * @var FormPersistenceManagerInterface
     */
    protected $formPersistenceManager;

    /**
     * @param FinisherContext $finisherContext
     */
    public function run(FinisherContext $finisherContext)
    {
        $identifier = $this->configuration['formDefinition'];
        $this->formRuntime = $finisherContext->getFormRuntime();

        if (!$identifier
            || $this->formRuntime->getFormDefinition()->getPersistenceIdentifier() !== $identifier
        ) {
            $this->cancelDispatch();
        }

        $this->formValues = $finisherContext->getFormValues();
        $this->controllerContext = $finisherContext->getControllerContext();
    }

    /**
     * Adds the fields values to the email properties so they can be used as
     * recipients for email notifications.
     *
     * @param PropertyContainer $container
     */
    public function fillPropertyEntries(PropertyContainer $container)
    {
        parent::fillPropertyEntries($container);

        if ($container->getPropertyType() !== Email::class) {
            return;
        }

        foreach ($this->formValues as $key => $value) {
            if ($container->hasEntry($key)) {
                $container->getEntry($key)->setValue($value);
            }
        }
    }

    /**
     * @param FormPersistenceManagerInterface $formPersistenceManager
     */
    public function injectFormPersistenceManager(FormPersistenceManagerInterface $formPersistenceManager)
    {
        $this->formPersistenceManager = $formPersistenceManager;
    }

    /**
     * @return array
     */
    public function getExampleProperties(): array
    {
        return [
            'formValues' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ],
        ];
    }
}
