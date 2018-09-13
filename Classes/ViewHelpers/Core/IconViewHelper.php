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

namespace CuyZ\Notiz\ViewHelpers\Core;

use Closure;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Type\Icon\IconState;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

/**
 * @deprecated Must be removed when TYPO3 v7 is not supported anymore.
 *
 * In TYPO3 v7: <f:be.buttons.icon icon="foo" />
 * In TYPO3 v8: <core:icon identifier="foo" />
 * This ViewHelper: <nz:core.icon identifier="foo" />
 */
class IconViewHelper extends AbstractBackendViewHelper implements CompilableInterface
{
    /**
     * View helper returns HTML, thus we need to disable output escaping
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initializes the arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('identifier', 'string', 'the table for the record icon', true);
        $this->registerArgument('size', 'string', 'the icon size', false, Icon::SIZE_SMALL);
        $this->registerArgument('overlay', 'string', '', false, null);
        $this->registerArgument('state', 'string', '', false, IconState::STATE_DEFAULT);
        $this->registerArgument('alternativeMarkupIdentifier', 'string', '', false, null);
    }

    /**
     * @return string
     */
    public function render()
    {
        return static::renderStatic(
            $this->arguments,
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * Prints icon html for $identifier key
     *
     * @param array $arguments
     * @param Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $identifier = $arguments['identifier'];
        $size = $arguments['size'];
        $overlay = $arguments['overlay'];
        $state = IconState::cast($arguments['state']);
        $alternativeMarkupIdentifier = $arguments['alternativeMarkupIdentifier'];
        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        return $iconFactory->getIcon($identifier, $size, $overlay, $state)->render($alternativeMarkupIdentifier);
    }
}
