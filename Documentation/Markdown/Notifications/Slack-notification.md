# Slack notification


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

The current implementation will either use `curl` or `Guzzle` depending on your
TYPO3 version.

![Channel tab][tab-channel]


## The message

In here you can configure the Slack message.

Depending on the selected event, you have access to markers with dynamic values.
These markers can be used in the message.

![Message tab][tab-message]

## Slack configuration

In here you can configure Slack specific options.

### The bot

In this section you can either pick a defined bot or configure a custom one for
the notification.

Bots are defined in TypoScript:

```typoscript
notiz {
    notifications {
        entitySlack {
            settings {
                bots {
                    pizza {
                        name = Mr Pizza
                        avatar = :pizza:
                    }
                }
            }
        }
    }
}
```

### The Slack channel

In this section you can either pick one or more defined channels or configure a
custom one for the notification.


#### Options

Each channel is composed out of three options:

##### `label`

It will be displayed in the backend and can be an `LLL:...` reference.

##### `webhookUrl`

The Slack URL to which the notification is sent to.

You can generate one by following the [official documentation][webhook-doc]
 
##### `target`

The `@user`, `MEMBER_ID` or `#slack-channel` to send the notification to.

#### Definition

Channels are defined in TypoScript:

```typoscript
notiz {
    notifications {
        entitySlack {
            settings {
                channels {
                    contact {
                        label = Contact channel
                        webhookUrl = https://hooks.slack.com/services/ABCDEFGHI/ABCDEFGHI/abcdefghijklmnopqrstuvw
                        target = #contact
                    }
                }
            }
        }
    }
}
```

![Slack tab][tab-slack]

## The resulting message

Here is an example of what the generated message looks like:

![Slack example][example]

---

[:books: Documentation index](../README.md)

[tab-general]: ../Images/SlackNotification/slack-general.png
[tab-event]: ../Images/SlackNotification/slack-event.png
[tab-channel]: ../Images/SlackNotification/slack-channel.png
[tab-message]: ../Images/SlackNotification/slack-message.png
[tab-slack]: ../Images/SlackNotification/slack-slack.png
[example]: ../Images/SlackNotification/slack-result.png
[webhook-doc]: https://api.slack.com/incoming-webhooks
