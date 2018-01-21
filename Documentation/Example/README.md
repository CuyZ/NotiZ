# Simple example

In this document we are going to create a notification to send an email every
time an extension is installed in the backend.

## Summary

- [Storing notifications](#storing-notifications)
- [Add a new notification](#add-a-new-notification)
- [Configuring the notification](#configuring-the-notification)
    - [The notification name](#the-notification-name)
    - [The event](#the-event)
    - [Email content](#email-content)
    - [Recipients](#recipients)
- [Triggering the notification](#triggering-the-notification)
- [The received email](#the-received-email)

## Storing notifications

First you need to create a folder somewhere in your page tree to hold your
notifications.

![Page tree empty folder][page-tree-empty]

## Add a new notification

Now that you have your folder you can add a new record in it.

We will create an email notification.

![Add a new notification][add-notification]

## Configuring the notification

### The notification name

The first thing to do is to name your notification.

This name will appear in list mode when you look into the folder.

![Notification tab general][tab-general]

### The event

NotiZ comes out of the box with an event for when an extension is installed.

You can then directly select this event in the list:

![Notification tab event][tab-event]

### Email content

This is where you configure the email content.

Here you can enter the subject and body and both can make use of the
available markers.

![Notification tab configuration][tab-configuration]

### Recipients

Here you can specify the email address to send the notification to.

For more info on recipients see: [Email notifications](../Notifications/Email-notification.md#recipients)

![Notification tab recipients][tab-recipients]

## Triggering the notification

Now that the notification is configured, let's install an extension.

![Installing an extension][install-extension]

## The received email

And here is the email sent:

![The final email][email]

---

[:books: Documentation index](../README.md)

[add-notification]: ../Images/Example/add-notification.png
[page-tree-empty]: ../Images/Example/page-tree-empty.png
[page-tree-full]: ../Images/Example/page-tree-full.png
[tab-configuration]: ../Images/Example/tab-configuration.png
[tab-event]: ../Images/Example/tab-event.png
[tab-general]: ../Images/Example/tab-general.png
[tab-recipients]: ../Images/Example/tab-recipients.png
[install-extension]: ../Images/Example/extensions.png
[email]: ../Images/Example/email.png
