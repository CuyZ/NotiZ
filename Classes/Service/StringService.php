<?php

/*
 * Copyright (C) 2017
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

namespace CuyZ\Notiz\Service;

use CuyZ\Notiz\Service\Traits\SelfInstantiateTrait;
use TYPO3\CMS\Core\SingletonInterface;

class StringService implements SingletonInterface
{
    use SelfInstantiateTrait;

    /**
     * Static alias method for:
     *
     * @see \CuyZ\Notiz\Service\StringService::doMark
     *
     * @param string $content
     * @return string
     */
    public static function mark($content)
    {
        return self::get()->doMark($content);
    }

    /**
     * Modifies the contents using the grave accent wrapper, by replacing it with the
     * HTML tag `samp`.
     *
     * Example:
     *
     * > Look at `foo` lorem ipsum...
     *
     * will become:
     *
     * > Look at <samp class="bg-info">foo</samp> lorem ipsum...
     *
     * @param string $content
     * @return string
     */
    public function doMark($content)
    {
        return preg_replace(
            '/`([^`]+)`/',
            '<samp class="bg-info">$1</samp>',
            $content
        );
    }
}
