<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
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

namespace CuyZ\Notiz\ViewHelpers\Notification;

use CuyZ\Notiz\Core\Notification\Notification;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class HasEventViewHelper extends AbstractViewHelper
{
    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'notification',
            Notification::class,
            '',
            true
        );
    }

    public function render()
    {
        /** @var Notification $notification */
        $notification = $this->arguments['notification'];

        return $notification->hasEventDefinition();
    }
}
