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

namespace CuyZ\Notiz\Controller\Backend\Administration;

use CuyZ\Notiz\Controller\Backend\BackendController;
use CuyZ\Notiz\Controller\Backend\Menu;

class IndexController extends BackendController
{
    /**
     * Shows several information about the extension.
     */
    public function processAction()
    {
    }

    /**
     * @inheritdoc
     */
    protected function getMenu()
    {
        return Menu::ADMINISTRATION_INDEX;
    }
}