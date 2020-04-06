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

namespace CuyZ\Notiz\Core\Definition\Builder\Component;

use CuyZ\Notiz\Core\Definition\Builder\Component\Processor\DefinitionProcessor;
use CuyZ\Notiz\Core\Definition\Builder\Component\Source\DefinitionSource;
use CuyZ\Notiz\Core\Exception\ClassNotFoundException;
use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Core\Exception\InvalidClassException;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Components container used in the definition builder.
 *
 * You may use it in your own components registration service to add new sources
 * and processors.
 *
 * @see \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder
 */
class DefinitionComponents
{
    /**
     * @var DefinitionSource[]
     */
    protected $sources = [];

    /**
     * @var DefinitionProcessor[]
     */
    protected $processors = [];

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Registers a new source component, that will later be used to fetch a
     * definition array from any origin.
     *
     * The given class name must implement the interface below:
     *
     * @see \CuyZ\Notiz\Core\Definition\Builder\Component\Source\DefinitionSource
     *
     * @param string $className
     * @return DefinitionSource
     *
     * @throws ClassNotFoundException
     * @throws InvalidClassException
     */
    public function addSource(string $className): DefinitionSource
    {
        if (!$this->hasSource($className)) {
            if (!class_exists($className)) {
                throw ClassNotFoundException::definitionSourceClassNotFound($className);
            }

            if (!in_array(DefinitionSource::class, class_implements($className))) {
                throw InvalidClassException::definitionSourceHasMissingInterface($className);
            }

            $this->sources[$className] = $this->objectManager->get($className);
        }

        return $this->sources[$className];
    }

    /**
     * @param string $className
     * @return bool
     */
    public function hasSource(string $className): bool
    {
        return true === isset($this->sources[$className]);
    }

    /**
     * @param string $className
     * @return DefinitionSource
     *
     * @throws EntryNotFoundException
     */
    public function getSource(string $className): DefinitionSource
    {
        if (false === $this->hasSource($className)) {
            throw EntryNotFoundException::definitionSourceNotFound($className);
        }

        return $this->sources[$className];
    }

    /**
     * @return DefinitionSource[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    /**
     * Registers a new processor component, that will later be used to modify
     * the definition object after it has been created from sources array.
     *
     * The given class name must implement the interface below:
     *
     * @see \CuyZ\Notiz\Core\Definition\Builder\Component\Processor\DefinitionProcessor
     *
     * @param string $className
     * @return DefinitionProcessor
     *
     * @throws ClassNotFoundException
     * @throws InvalidClassException
     */
    public function addProcessor(string $className): DefinitionProcessor
    {
        if (false === $this->hasProcessor($className)) {
            if (!class_exists($className)) {
                throw ClassNotFoundException::definitionProcessorClassNotFound($className);
            }

            if (!in_array(DefinitionProcessor::class, class_implements($className))) {
                throw InvalidClassException::definitionProcessorHasMissingInterface($className);
            }

            $this->processors[$className] = $this->objectManager->get($className);
        }

        return $this->processors[$className];
    }

    /**
     * @param string $className
     * @return bool
     */
    public function hasProcessor(string $className): bool
    {
        return true === isset($this->processors[$className]);
    }

    /**
     * @param string $className
     * @return DefinitionProcessor
     *
     * @throws EntryNotFoundException
     */
    public function getProcessor(string $className): DefinitionProcessor
    {
        if (false === $this->hasProcessor($className)) {
            throw EntryNotFoundException::definitionProcessorNotFound($className);
        }

        return $this->processors[$className];
    }

    /**
     * @return DefinitionProcessor[]
     */
    public function getProcessors(): array
    {
        return $this->processors;
    }
}
