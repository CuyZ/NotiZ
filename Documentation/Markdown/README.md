# ![NotiZ](Images/NotiZ.svg) NotiZ • Documentation

NotiZ is a ![TYPO3](Images/TYPO3.svg)[TYPO3](https://typo3.com)
[extension](https://extensions.typo3.org/extension/notiz/) allowing to easily
dispatch notifications (emails, SMS, Slack messages) bound to events sent by 
your application.

To ease editors lives, everything can be managed directly in the TYPO3 backend.

> ![Slack](Images/Slack.svg) Join the discussion on Slack in channel [**#ext-notiz**](https://typo3.slack.com/messages/ext-notiz)! – You don't have access to TYPO3 Slack? Get your Slack invitation [by clicking here](https://forger.typo3.org/slack)!

You can find below documentation on how to use and extend NotiZ.

## Summary

- [Installation](Installation/README.md)
- [Simple example](Example/README.md)
    - [Example video](Example/Video.md)
- [Notifications](Notifications/README.md)
    - [Email notification](Notifications/Email/README.md)
        - [Customize email body](Notifications/Email/Customize-email.md)
    - [Slack notification](Notifications/Slack-notification.md)
    - [Log notification](Notifications/Log-notification.md)
- [Events](Events/README.md)
    - [Create a custom event](Events/Create-a-custom-event.md)
    - [Provided events](Events/ProvidedEvents/README.md)
        - TYPO3
            - [Caches cleared](./Events/ProvidedEvents/TYPO3/CachesCleared.md)
            - [Extension installed](./Events/ProvidedEvents/TYPO3/ExtensionInstalled.md)
        - Scheduler
            - [Successful task](./Scheduler/SchedulerTaskWasExecuted.md)
            - [Failed task](./Scheduler/SchedulerTaskExecutionFailed.md)
        - Extension `form`
            - [Form finisher](./Form/DispatchFormNotification.md)
- Developers
    - [Add TypoScript definition](Developers/Add-TypoScript-definition.md)
    - [Signals provided by the extension](Developers/Signals-connection.md)
- [Known issues](Known-issues.md)
