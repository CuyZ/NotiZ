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

namespace CuyZ\Notiz\Domain\Property\Builder;

use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Builder\PropertyBuilder;
use CuyZ\Notiz\Core\Property\Factory\PropertyDefinition;
use CuyZ\Notiz\Core\Property\Service\TagsPropertyService;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Provided property builder that will fetch the properties using an event class
 * attributes and their annotations.
 *
 * @see \CuyZ\Notiz\Core\Property\Service\TagsPropertyService
 */
class TagsPropertyBuilder implements PropertyBuilder, SingletonInterface
{
    /**
     * @var TagsPropertyService
     */
    protected $tagsPropertyService;

    /**
     * @param TagsPropertyService $tagsPropertyService
     */
    public function __construct(TagsPropertyService $tagsPropertyService)
    {
        $this->tagsPropertyService = $tagsPropertyService;
    }

    /**
     * @param PropertyDefinition $definition
     * @param Notification $notification
     */
    public function build(PropertyDefinition $definition, Notification $notification)
    {
        $this->tagsPropertyService->fillPropertyDefinition($definition);
    }
}
