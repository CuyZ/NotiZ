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

namespace CuyZ\Notiz\Core\Notification\TCA\User;

use CuyZ\Notiz\Service\LocalizationService;
use CuyZ\Notiz\Service\StringService;
use TYPO3\CMS\Core\SingletonInterface;

class MissingCkEditorPreset implements SingletonInterface
{
    /**
     * If a RTE is using a missing CKEditor preset, a message is shown to the
     * user to help him fix it.
     *
     * @param array $parent
     * @return string
     */
    public function process(array $parent): string
    {
        $preset = $parent['parameters']['preset'];

        $message = LocalizationService::localize('Notification/Entity:field.rte.ck_editor_preset_missing', [$preset]);
        $message = StringService::mark($message, '<code>$1</code>');

        return '<span class="bg-danger">' . $message . '</span>';
    }
}
