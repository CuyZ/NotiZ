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

namespace CuyZ\Notiz\Service;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Traits\ExtendedSelfInstantiateTrait;
use Throwable;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Validation\Error;

class RuntimeService implements SingletonInterface
{
    use ExtendedSelfInstantiateTrait {
        get as getInstance;
    }

    /**
     * If an exception/error is thrown during the runtime of the application, it
     * will be stored here to prevent blocking the user from accessing the TYPO3
     * backend.
     *
     * The exception can be shown in the backend module for debugging purpose.
     *
     * @var Throwable
     */
    protected $exception;

    /**
     * @param Throwable $exception
     */
    public function setException(Throwable $exception)
    {
        $error = new Error('Runtime exception: ' . $exception->getMessage(), 1507489776);
        DefinitionService::get()->getValidationResult()->addError($error);

        $this->exception = $exception;
    }

    /**
     * @return Throwable|null [PHP 7.1]
     */
    public function getException()
    {
        return $this->exception;
    }
}
