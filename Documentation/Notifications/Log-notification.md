# Log notification


## General configuration

The title can be an arbitrary label that you will use to identify the
notification in the TYPO3 backend.

![General tab][tab-general]


## The event

On this tab, you can select which event you want the notification to listen to.

Some events might have a custom configuration. For instance, the
`TYPO3 > Scheduler task was executed` event allows you to select which specific
task will fire the event.

![Event tab][tab-event]


## The channel

You can choose the logger that will do the actual sending.

TYPO3 comes out of the box with a basic logger, more custom implementations may
be added in the future.

![Channel tab][tab-channel]


## The log content

In here you can configure the log message and level.

Depending on the selected event, you have access to markers with dynamic values.
These markers can be used in the message.

The log level is a [PSR-3 Log Level][link-psr3].

![Configuration tab][tab-configuration]


[tab-general]: /Documentation/Images/LogNotification/log-general.png
[tab-event]: /Documentation/Images/LogNotification/log-event.png
[tab-channel]: /Documentation/Images/LogNotification/log-channel.png
[tab-configuration]: /Documentation/Images/LogNotification/log-configuration.png
[link-psr3]: http://www.php-fig.org/psr/psr-3/#psrlogloglevel
