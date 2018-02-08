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

namespace CuyZ\Notiz\ViewHelpers\Slot;

use Closure;
use CuyZ\Notiz\Core\Exception\DuplicateEntryException;
use CuyZ\Notiz\Core\Property\Service\MarkerParser;
use CuyZ\Notiz\Domain\Property\Marker;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\View\Slot\SlotContainer;
use CuyZ\Notiz\View\Slot\SlotView;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Fluid\Core\Compiler\TemplateCompiler;
use TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\AbstractNode;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\ViewHelperVariableContainer;

/**
 * Will process and render the wanted slot, by getting the value filled by the
 * user and replacing markers within it.
 *
 * This view-helper can be used in several ways:
 *
 * Inline
 * ------
 *
 * The processed slot value will be returned.
 *
 * ```
 * <nz:slot.render name="MySlot"
 *                 markers="{foo: 'bar'}" />
 * ```
 *
 * Conditional
 * -----------
 *
 * Can be used to check whether the slot exists, and do something if it doesn't.
 *
 * When using this way, a variable `slotValue` becomes accessible within the
 * view-helper, that contains the processed value of the slot. However, this
 * variable is filled only when the slot exists and can be processed.
 *
 * ```
 * <nz:slot.render name="SomeOptionalSlot">
 *     <f:then>
 *         {slotValue -> f:format.html()}
 *     </f:then>
 *     <f:else>
 *         Some default value
 *     </f:else>
 * </nz:slot.render>
 * ```
 *
 * Wrapping
 * --------
 *
 * You may need to add HTML around the slot value only when the slot exists.
 *
 * ```
 * <nz:slot.render name="SomeOptionalSlot">
 *     <hr />
 *
 *     <div class="some-class">
 *         {slotValue}
 *     </div>
 * </nz:slot.render>
 * ```
 */
class RenderViewHelper extends AbstractConditionViewHelper
{
    /**
     * Unfortunately, the rendering context is not passed to the method
     * `evaluateCondition`. We need to first save the variable container in the
     * class before the method is called.
     *
     * @var ViewHelperVariableContainer
     */
    protected static $currentVariableContainer;

    /**
     * @deprecated Must be removed when TYPO3 v7 is not supported anymore.
     *
     * @var AbstractNode[]
     */
    private $childNodesLegacy = [];

    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('name', 'string', 'Name of the slot that will be rendered.', true);
        $this->registerArgument('markers', 'array', 'Additional markers that will be added to the slot and can be used within the FlexForm.', false, []);

        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '8.0.0', '>=')) {
            unset($this->argumentDefinitions['condition']);
        }
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        if (empty($this->childNodesLegacy)) {
            return self::getSlotValue($this->arguments, $this->renderingContext);
        } else {
            self::addSlotValueToVariables($this->arguments, $this->renderingContext);

            return parent::render();
        }
    }

    /**
     * @inheritdoc
     */
    public static function renderStatic(array $arguments, Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        self::addSlotValueToVariables($arguments, $renderingContext);

        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }

    /**
     * Adds a new variable `slotValue` to the view, that contains the processed
     * value of the slot.
     *
     * @param array $arguments
     * @param RenderingContextInterface $renderingContext
     */
    protected static function addSlotValueToVariables(array $arguments, RenderingContextInterface $renderingContext)
    {
        $slotValue = self::getSlotValue($arguments, $renderingContext);
        $renderingContext->getTemplateVariableContainer()->add('slotValue', $slotValue);
    }

    /**
     * @inheritdoc
     */
    public function compile($argumentsName, $closureName, &$initializationPhpCode, AbstractNode $node, TemplateCompiler $compiler)
    {
        if (empty($node->getChildNodes())) {
            return sprintf(
                '%s::getSlotValue(%s, $renderingContext)',
                get_class($this),
                $argumentsName
            );
        } else {
            return parent::compile($argumentsName, $closureName, $initializationPhpCode, $node, $compiler);
        }
    }

    /**
     * Fetches the final value of the wanted slot, by getting the user value and
     * replacing markers in it.
     *
     * @param array $arguments
     * @param RenderingContextInterface $renderingContext
     * @return string
     *
     * @throws DuplicateEntryException
     */
    public static function getSlotValue(array $arguments, RenderingContextInterface $renderingContext)
    {
        self::$currentVariableContainer = $renderingContext->getViewHelperVariableContainer();

        $result = '';
        $name = $arguments['name'];
        $newMarkers = $arguments['markers'];

        $slotValues = self::getSlotValues();
        $markers = self::getMarkers();

        foreach ($newMarkers as $key => $value) {
            if (isset($markers[$key])) {
                throw DuplicateEntryException::markerAlreadyDefined($key, $name);
            }
        }

        if (isset($slotValues[$name])) {
            foreach ($newMarkers as $key => $value) {
                $marker = new Marker($key);
                $marker->setValue($value);

                $markers[$key] = $marker;
            }

            $markerParser = Container::get(MarkerParser::class);

            $result = $markerParser->replaceMarkers(
                $slotValues[$name],
                $markers
            );
        }

        return $result;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    protected static function evaluateCondition($arguments = null)
    {
        return self::getSlotContainer()->has($arguments['name']);
    }

    /**
     * @deprecated Must be removed when TYPO3 v7 is not supported anymore.
     *
     * @param array $childNodes
     */
    public function setChildNodes(array $childNodes)
    {
        $this->childNodesLegacy = $childNodes;

        parent::setChildNodes($childNodes);
    }

    /**
     * @return SlotContainer
     */
    protected static function getSlotContainer()
    {
        return self::$currentVariableContainer->get(SlotView::class, SlotView::SLOT_CONTAINER);
    }

    /**
     * @return array
     */
    protected static function getSlotValues()
    {
        return self::$currentVariableContainer->get(SlotView::class, SlotView::SLOT_VALUES);
    }

    /**
     * @return array
     */
    protected static function getMarkers()
    {
        return self::$currentVariableContainer->get(SlotView::class, SlotView::MARKERS);
    }
}
