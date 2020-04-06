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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Channels;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use Romm\ConfigurationObject\Traits\ConfigurationObject\StoreArrayIndexTrait;

class Channel extends AbstractDefinitionComponent
{
    use StoreArrayIndexTrait;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $webhookUrl;

    /**
     * @var string
     */
    protected $target;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->getArrayIndex();
    }
}
