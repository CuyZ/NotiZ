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

namespace CuyZ\Notiz\Domain\Event\TYPO3;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;

class BackendUserLoggedIn extends AbstractEvent implements ProvidesExampleProperties
{
    /**
     * @label Event/TYPO3:backend_user_logged_in.marker.user
     * @marker
     *
     * @var array
     */
    protected $user;

    /**
     * @label Event/TYPO3:backend_user_logged_in.marker.email
     * @email
     *
     * @var string
     */
    protected $email;

    /**
     * @param array $user
     */
    public function run(array $user)
    {
        $this->user = $user['user'];
        $this->email = $this->user['email'];
    }

    /**
     * @return array
     */
    public function getExampleProperties(): array
    {
        return [
            'user' => [
                'username' => 'John Doe',
                'email' => 'john.doe@example.com',
            ]
        ];
    }
}
