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

namespace CuyZ\Notiz\ViewHelpers\Notification\Link;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Definition\Tree\Notification\NotificationDefinition;
use CuyZ\Notiz\Core\Notification\Creatable;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class CreateViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerUniversalTagAttributes();

        $this->registerArgument(
            'notificationDefinition',
            NotificationDefinition::class,
            '',
            true
        );

        $this->registerArgument(
            'eventDefinition',
            EventDefinition::class,
            ''
        );

        $this->registerArgument(
            'addUriTemplate',
            'bool',
            ''
        );
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        /** @var NotificationDefinition $notificationDefinition */
        $notificationDefinition = $this->arguments['notificationDefinition'];

        /** @var Creatable $className */
        $className = $notificationDefinition->getClassName();

        if (!in_array(Creatable::class, class_implements($className))
            || !$className::isCreatable()
        ) {
            return '';
        }

        if ($this->arguments['addUriTemplate']) {
            $this->tag->addAttribute('data-href', $className::getCreationUri('#EVENT#'));
        }

        /** @var EventDefinition $eventDefinition */
        $eventDefinition = $this->arguments['eventDefinition'];

        $selectedEvent = $eventDefinition
            ? $eventDefinition->getFullIdentifier()
            : null;

        $this->tag->addAttribute('href', $className::getCreationUri($selectedEvent));
        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}
