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

namespace CuyZ\Notiz\View\Slot;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\ViewHelpers\Slot\SlotViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class SlotView extends StandaloneView
{
    const SLOT_CONTAINER = 'SlotContainer';
    const SLOT_VALUES = 'SlotValues';
    const MARKERS = 'Marker';

    /**
     * @var SlotContainer
     */
    protected $slots;

    /**
     * @var EventDefinition
     */
    protected $eventDefinition;

    /**
     * @param EventDefinition $eventDefinition
     */
    public function __construct(EventDefinition $eventDefinition)
    {
        parent::__construct();

        $this->eventDefinition = $eventDefinition;
    }

    /**
     * Will render the section `Slots` of the view. This will allow collecting
     * all the slots for the event, that are then returned.
     *
     * @return SlotContainer
     */
    public function getSlots(): SlotContainer
    {
        if (!$this->slots) {
            $this->slots = GeneralUtility::makeInstance(SlotContainer::class);

            $this->baseRenderingContext
                ->getViewHelperVariableContainer()
                ->add(SlotViewHelper::class, SlotViewHelper::SLOT_CONTAINER, $this->slots);

            $variables = [
                'event' => $this->eventDefinition,
                'definition' => DefinitionService::get()->getDefinition(),
            ];

            $this->renderSection('Slots', $variables, true);
        }

        return $this->slots;
    }

    /**
     * @param array $slotsValues
     * @param array $markers
     * @return string
     */
    public function renderWithSlots(array $slotsValues, array $markers): string
    {
        $viewHelperVariableContainer = $this->baseRenderingContext->getViewHelperVariableContainer();

        $viewHelperVariableContainer->add(self::class, self::SLOT_CONTAINER, $this->getSlots());
        $viewHelperVariableContainer->add(self::class, self::SLOT_VALUES, $slotsValues);
        $viewHelperVariableContainer->add(self::class, self::MARKERS, $markers);

        return $this->render();
    }

    /**
     * @return EventDefinition
     */
    public function getEventDefinition(): EventDefinition
    {
        return $this->eventDefinition;
    }
}
