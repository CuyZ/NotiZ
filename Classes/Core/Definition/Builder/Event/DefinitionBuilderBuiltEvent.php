<?php


namespace CuyZ\Notiz\Core\Definition\Builder\Event;


use Romm\ConfigurationObject\ConfigurationObjectInterface;

class DefinitionBuilderBuiltEvent
{

    /**
     * @var ConfigurationObjectInterface
     */
    protected $definitionObject;

    /**
     * DefinitionBuilderBuiltEvent constructor.
     * @param ConfigurationObjectInterface $definitionObject
     */
    public function __construct(ConfigurationObjectInterface $definitionObject)
    {
        $this->definitionObject = $definitionObject;
    }

    /**
     * @return ConfigurationObjectInterface
     */
    public function getDefinitionObject(): ConfigurationObjectInterface
    {
        return $this->definitionObject;
    }

}
