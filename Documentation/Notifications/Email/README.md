# Email notification


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

You can choose the mailer that will do the actual sending.

TYPO3 comes out of the box with a basic mailer, more custom implementations may
be added in the future.

![Channel tab][tab-channel]


## The email content

In here you can configure the mail subject and body.

Depending on the selected event, you have access to markers with dynamic values.
These markers can be used in both the subject and the body.

The body may be customized for complex emails. See the chapter 
“[Customize email body][customize-email-body]” for more information.

![Configuration tab][tab-configuration]

## Recipients

For each type of recipients, you can add as many emails as needed.

Emails can be written in 2 formats:
- Without the name: `john@example.com`
- With the name: `John Smith <john@example.com>`

Some events provide dynamic recipient emails. For instance, a contact form
asking for the user's email address can provide it as a recipient "User that
filled the form".

### Global recipients

You can also define globally available recipients that you can then use in
any of your notifications.

They are configurable in TypoScript at the path:
`notiz.notifications.entityEmail.settings.globalRecipients`.

This is useful for recipients that are shared between several notifications.

![Recipients tab][tab-recipients]


## Sender

The default sender is configurable in TypoScript at the path:
`notiz.notifications.entityEmail.settings.defaultSender`.
You can also override it by notification.

![Sender tab][tab-sender]

---

[:books: Documentation index](../../README.md)

[customize-email-body]: Customize-email-body.md

[tab-general]: /Documentation/Images/EmailNotification/email-general.png
[tab-event]: /Documentation/Images/EmailNotification/email-event.png
[tab-channel]: /Documentation/Images/EmailNotification/email-channel.png
[tab-configuration]: /Documentation/Images/EmailNotification/email-configuration.png
[tab-recipients]: /Documentation/Images/EmailNotification/email-recipients.png
[tab-sender]: /Documentation/Images/EmailNotification/email-sender.png
