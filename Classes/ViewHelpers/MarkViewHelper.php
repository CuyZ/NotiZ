<?php

namespace CuyZ\Notiz\ViewHelpers;

use CuyZ\Notiz\Service\StringService;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Applies the "marker" behaviour to the given content:
 *
 * @see \CuyZ\Notiz\Service\StringService::doMark
 */
class MarkViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @inheritdoc
     */
    public function initializeArguments()
    {
        $this->registerArgument('content', 'string', 'Content in which markers will be replaced');
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        return self::renderStatic($this->arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    /**
     * @inheritdoc
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $content = isset($arguments['content'])
            ? $arguments['content']
            : $renderChildrenClosure();

        return StringService::mark($content);
    }
}
