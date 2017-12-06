<?php

namespace CuyZ\Notiz\ViewHelpers;

use CuyZ\Notiz\Service\LocalizationService;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class TViewHelper extends AbstractViewHelper implements CompilableInterface
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
        $this->registerArgument('key', 'string', 'The translation key');
        $this->registerArgument('args', 'array', 'Translation arguments');
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
        $key = isset($arguments['key'])
            ? $arguments['key']
            : $renderChildrenClosure();

        $args = isset($arguments['args'])
            ? $arguments['args']
            : [];

        return LocalizationService::localize($key, $args);
    }
}
