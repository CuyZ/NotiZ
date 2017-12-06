<?php

namespace CuyZ\Notiz\Notification;

use CuyZ\Notiz\Definition\Tree\Notification\Channel\ChannelDefinition;

/**
 * This interface is used to identify notifications that are supported by
 * multiple channels.
 *
 * The shouldDispatch method is used to determine which channels to dispatch
 * the notification on.
 */
interface MultipleChannelsNotification
{
    /**
     * This method allows you to decide which channels this notification
     * should be dispatched on.
     *
     * It receives all compatible channels definitions one at a time and
     * must return true if you want the given channel to dispatch the
     * notification.
     *
     * @param ChannelDefinition $definition
     * @return bool
     */
    public function shouldDispatch(ChannelDefinition $definition);
}
