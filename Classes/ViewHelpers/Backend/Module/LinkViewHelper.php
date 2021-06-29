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

namespace CuyZ\Notiz\ViewHelpers\Backend\Module;

use CuyZ\Notiz\Backend\Module\ModuleHandler;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class LinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerUniversalTagAttributes();

        $this->registerArgument(
            'module',
            'string',
            'Name of the module, for instance Manager or Administration.',
            true
        );

        $this->registerArgument(
            'controller',
            'string',
            ''
        );

        $this->registerArgument(
            'action',
            'string',
            ''
        );

        $this->registerArgument(
            'arguments',
            'array',
            ''
        );

        $this->registerArgument(
            'frame',
            'bool',
            'Should the link open the TYPO3 content frame?'
        );

        $this->registerArgument(
            'parentFrame',
            'bool',
            'If this view-helper is called from inside TYPO3 module frame, this parameter must be set.'
        );
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        $content = $this->renderChildren();

        $moduleHandler = ModuleHandler::for($this->arguments['module']);

        if (!$moduleHandler->canBeAccessed()) {
            return $content;
        }

        $uri = $moduleHandler
            ->getUriBuilder()
            ->forController($this->arguments['controller'])
            ->forAction($this->arguments['action'])
            ->withArguments($this->arguments['arguments'] ?: [])
            ->build();

        $this->tag->addAttribute('href', $this->arguments['frame'] ? 'javascript:void(0);' : $uri);

        if ($this->arguments['frame']) {
            $onClick = "TYPO3.ModuleMenu.App.showModule('{$moduleHandler->getModuleName()}', '{$uri->getQuery()}');";

            if ($this->arguments['parentFrame']) {
                $onClick = 'parent.' . $onClick;
            }
            $this->tag->addAttribute('onclick', $onClick);
        }

        $this->tag->setContent($content);

        return $this->tag->render();
    }
}
