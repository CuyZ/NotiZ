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

use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Notification\Viewable;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ShowViewHelper extends AbstractTagBasedViewHelper
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
            'notification',
            Notification::class,
            '',
            true
        );

        $this->registerArgument(
            'graceful',
            'bool',
            'If the link can not be generated, the content will still be displayed without the link.'
        );
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        /** @var Notification $notification */
        $notification = $this->arguments['notification'];

        if (!$notification instanceof Viewable) {
            if ($this->arguments['graceful']) {
                return $this->renderChildren();
            }

            return '';
        }

        $this->tag->addAttribute('href', $notification->getViewUri());
        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}
