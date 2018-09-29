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

namespace CuyZ\Notiz\Controller\Backend\Manager;

use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Support\Url;

/**
 * Lists all registered events.
 */
class ListEventsController extends ManagerController
{
    public function processAction()
    {
        $this->view->assign('documentationUrl', Url::documentationCreateCustomEvent());
    }

    /**
     * @return string
     */
    protected function getMenu()
    {
        return Menu::MANAGER_EVENTS;
    }
}
