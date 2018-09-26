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

namespace CuyZ\Notiz\ViewHelpers\Format;

use TYPO3\CMS\Fluid\Core\Compiler\TemplateCompiler;
use TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\AbstractNode;
use TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class Nl2brTrimViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @inheritdoc
     */
    public function render()
    {
        return \nl2br(\trim($this->renderChildren()));
    }

    /**
     * @inheritdoc
     */
    public function compile(
        $argumentsVariableName,
        $closureName,
        &$initializationPhpCode,
        AbstractNode $syntaxTreeNode,
        TemplateCompiler $templateCompiler
    ) {
        return sprintf(
            '\nl2br(\trim(%s()))',
            $closureName
        );
    }
}
