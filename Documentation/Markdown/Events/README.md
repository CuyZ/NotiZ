# Events

Events are at the core of NotiZ. Each event is a PHP class representing
something happening in your application.
They can contain variables that will be made available in the dispatched
notification.
An event class is bound to either a TYPO3 signal or a hook.

## Provided events

NotiZ comes with several events out of the box. You can use them directly after
installing the extension.

See the [list of provided events](./ProvidedEvents).

### Scheduler

Once a scheduler task has finished running, it will trigger a successful or failed event
that a notification can listen to.

The notification can be sent for a selected list of tasks and will have access
to the task data (uid, title, description).

If the notification is listening to a successful task, it will have access to the result output.

If the notification is listening to a failed task, it will have access to the error message.

## Create a custom event

You can read the documentation on how to [create a custom event](./Create-a-custom-event.md).

---

[:books: Documentation index](../README.md)
