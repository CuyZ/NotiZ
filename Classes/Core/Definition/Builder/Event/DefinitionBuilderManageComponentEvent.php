<?php

namespace CuyZ\Notiz\Core\Definition\Builder\Event;

use CuyZ\Notiz\Core\Definition\Builder\Component\DefinitionComponents;

class DefinitionBuilderManageComponentEvent
{
    /**
     * @var DefinitionComponents
     */
    protected $components;

    /**
     * DefinitionBuilderComponentEvent constructor.
     * @param DefinitionComponents $components
     */
    public function __construct(DefinitionComponents $components)
    {
        $this->components = $components;
    }

    /**
     * @return DefinitionComponents
     */
    public function getComponents(): DefinitionComponents
    {
        return $this->components;
    }

}
