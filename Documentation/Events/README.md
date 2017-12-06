# Events

Events are at the core of NotiZ. Each event is a PHP class representing
something happening in your application.
They can contain variables that will be made available in the dispatched
notification.
An event class is bound to either a TYPO3 signal or a hook.

An event should extend `\CuyZ\Notiz\Event\AbstractEvent`.

In addition to the required methods, the event must implement the `run` method.
This method takes the signal/hook arguments as parameters.

If you need a more specific implementation for your event, you can instead
implement the interface `\CuyZ\Notiz\Event\Event`.

Once your event is created, you will have to register it into NotiZ.

## Provided events

NotiZ comes with several events out of the box. You can use them directly after
installing the extension.

### Scheduler

Once a scheduler task has finished running, it will trigger a successful or failed event
that a notification can listen to.

The notification can be sent for a selected list of tasks and will have access
to the task data (uid, title, description).

If the notification is listening to a successful task, it will have access to the result output.

If the notification is listening to a failed task, it will have access to the error message.

### TYPO3 Backend

Several events from the TYPO3 backend can be listened to.

#### Cache cleared

You can register a notification for when a specific cache is cleared (front, all, a page, etc.).

For a page, you will have access to the uid.

#### Extension installed

With this event, you will have access to the extension title, key, description and version.

## Create a custom event

You can read the documentation on how to [create a custom event](./Create-a-custom-event.md).
