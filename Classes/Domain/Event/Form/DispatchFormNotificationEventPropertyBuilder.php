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

namespace CuyZ\Notiz\Domain\Event\Form;

use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Builder\PropertyBuilder;
use CuyZ\Notiz\Core\Property\Factory\PropertyDefinition;
use CuyZ\Notiz\Core\Property\Service\TagsPropertyService;
use CuyZ\Notiz\Domain\Property\Email;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Form\Domain\Factory\ArrayFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;

class DispatchFormNotificationEventPropertyBuilder implements PropertyBuilder, SingletonInterface
{
    /**
     * @var TagsPropertyService
     */
    protected $tagsPropertyService;

    /**
     * @var FormPersistenceManagerInterface
     */
    protected $formPersistenceManager;

    /**
     * @var ArrayFormFactory
     */
    protected $arrayFormFactory;

    /**
     * @param TagsPropertyService $tagsPropertyService
     * @param FormPersistenceManagerInterface $formPersistenceManager
     * @param ArrayFormFactory $arrayFormFactory
     */
    public function __construct(
        TagsPropertyService $tagsPropertyService,
        FormPersistenceManagerInterface $formPersistenceManager,
        ArrayFormFactory $arrayFormFactory
    ) {
        $this->tagsPropertyService = $tagsPropertyService;
        $this->formPersistenceManager = $formPersistenceManager;
        $this->arrayFormFactory = $arrayFormFactory;
    }

    /**
     * Will fetch all fields from the form definition and add them to the
     * definition of the email properties.
     *
     * This will allow selecting fields that can contain an email address as a
     * recipient for email notifications.
     *
     * @param PropertyDefinition $definition
     * @param Notification $notification
     * @return void
     */
    public function build(PropertyDefinition $definition, Notification $notification)
    {
        if ($definition->getPropertyType() !== Email::class) {
            $this->tagsPropertyService->fillPropertyDefinition($definition);

            return;
        }

        $eventConfiguration = $notification->getEventConfiguration();

        $identifier = $eventConfiguration['formDefinition'] ?? null;

        if (!$identifier) {
            return;
        }

        if (!$this->formPersistenceManager->exists($identifier)) {
            return;
        }

        $formDefinition = $this->getFormDefinition($identifier);

        /*
         * Unfortunately there is no getter method to fetch all elements from a
         * form definition, so we use this little hack to get them.
         */
        $elements = ObjectAccess::getProperty($formDefinition, 'elementsByIdentifier', true);

        foreach ($elements as $element) {
            /** @var FormElementInterface $element */
            $definition->addEntry($element->getIdentifier())
                ->setLabel($element->getLabel() . ' (' . $element->getIdentifier() . ')');
        }
    }

    /**
     * @param string $identifier
     * @return FormDefinition
     */
    protected function getFormDefinition(string $identifier): FormDefinition
    {
        $formDefinitionArray = $this->formPersistenceManager->load($identifier);

        return $this->arrayFormFactory->build($formDefinitionArray);
    }
}
