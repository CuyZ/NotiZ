<?php


namespace CuyZ\Notiz\Core\Event;


class NotizEvent
{

    protected string $identifier;
    protected array $args;

    public function __construct(string $identifier, array $args)
    {
        $this->identifier = $identifier;
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

}
