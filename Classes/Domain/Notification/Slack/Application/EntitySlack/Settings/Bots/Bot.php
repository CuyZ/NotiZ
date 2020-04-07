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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Bots;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use Romm\ConfigurationObject\Traits\ConfigurationObject\StoreArrayIndexTrait;

class Bot extends AbstractDefinitionComponent
{
    use StoreArrayIndexTrait;

    const IDENTIFIER_PREFIX = '__NOTIZ_SLACK_BOT_';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return self::IDENTIFIER_PREFIX . $this->getArrayIndex();
    }
}
