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

namespace CuyZ\Notiz\ViewHelpers\Slot;

use CuyZ\Notiz\View\Slot\Application\Slot;
use CuyZ\Notiz\View\Slot\Application\TextSlot;

class TextViewHelper extends SlotViewHelper
{
    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('rte', 'bool', 'Should rich text be enabled?', false, false);
        $this->registerArgument('rteMode', 'string', 'Mode of the RTE: can be a CKEditor preset or a RteHtmlArea configuration.', false);
    }

    /**
     * @return Slot
     */
    protected function getSlot(): Slot
    {
        $rte = $this->arguments['rte'];
        $rteMode = $this->arguments['rteMode'];

        return new TextSlot(
            $this->getSlotName(),
            $this->getSlotLabel(),
            $rte,
            $rteMode
        );
    }
}
