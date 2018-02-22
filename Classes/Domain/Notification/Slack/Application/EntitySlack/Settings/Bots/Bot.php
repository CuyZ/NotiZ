<?php

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Bots;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;

class Bot extends AbstractDefinitionComponent
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
