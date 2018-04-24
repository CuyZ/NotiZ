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

namespace CuyZ\Notiz\Core\Event;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Notification\Notification;

/**
 * Interface for an event that will be processed when a hook/signal is called.
 *
 * The purpose of an event is to process the data coming from the hook/signal.
 * It may fill so-called "properties", that are then used by the notifications
 * bound to this very event, to dispatch it with correct information.
 *
 * An example of an event usage could be:
 *
 * Event:
 *  -> A user has registered.
 *
 * Notifications:
 *  -> #1 - A mail is sent to the user with registration information.
 *  -> #2 - A different mail is sent to an administrator to warn him.
 *  -> #3 - A flash message is queued to welcome the user on next page.
 *
 * In this example, the job of the event would be to fetch the user name and
 * email address, and fill the appropriate properties with these values so they
 * can be used by the three notifications.
 *
 * The user name will be inserted in the messages, the email address will allow
 * sending the email #1 to the user correctly.
 *
 * ---
 *
 * The event workflow has three phases:
 *
 * #1 - Property definition
 * ------------------------
 *
 * In order for an event to be able to fill properties, it has to
 * implements the interface: @see \CuyZ\Notiz\Core\Event\Support\HasProperties
 *
 * The static method `getPropertyBuilder` must return an instance of a property
 * builder that will be used to fetch the definition for used properties.
 *
 * #2 - Dispatch process
 * ---------------------
 *
 * When the actual signal/hook is sent from anywhere during the TYPO3 rendering
 * process, an event entry is created and its dispatch process begins.
 *
 * During this phase, the role of the event is to fetch all the useful data that
 * was passed by the signal/hook, and store it in any way as long as these data
 * can be accessed during the phase #3.
 *
 * For this, the event class should implement a method named `run()` that can
 * take as many parameters as needed (these parameters come from the hook/signal
 * that triggered the event).
 *
 * #3 - Properties filling
 * -----------------------
 *
 * Now that the data was saved during phase #2, the notifications bound to this
 * event will want to access to this data.
 *
 * @see \CuyZ\Notiz\Core\Event\Support\HasProperties::fillPropertyEntries
 *
 * In this method, the properties that were added in the definitions during
 * phase #1 should be filled with correct values.
 */
interface Event
{
    /**
     * Must return the definition for this event instance.
     *
     * Please note that event factory will give the definition instance as first
     * argument for the constructor of your event, you may use it to store it in
     * your object.
     *
     * @return EventDefinition
     */
    public function getDefinition();

    /**
     * @return Notification
     */
    public function getNotification();
}
