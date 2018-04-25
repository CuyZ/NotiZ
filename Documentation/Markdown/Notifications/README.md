# Notifications

With NotiZ you can listen to events happening in your TYPO3 installation and
send notifications to different channels (email, log, etc.).

These notification are created in the TYPO3 backend.

To make one, you just have to create a new record for the desired channel in
a folder.

In those records, you will have access to data specific to the selected event.

## Existing notifications

NotiZ provides three types of notifications out of the box:
[emails][email-notification], [slack][slack-notification] and [logs][log-notification].

---

[:books: Documentation index](../README.md)

[email-notification]: Email/README.md
[log-notification]: Log-notification.md
[slack-notification]: Slack-notification.md
