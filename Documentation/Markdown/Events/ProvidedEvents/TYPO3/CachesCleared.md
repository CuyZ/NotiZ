# Caches cleared

This event is fired every time some cache is cleared.

You can use the following properties in your notifications:

| Property     | Description                                                                                                  |
|--------------|--------------------------------------------------------------------------------------------------------------|
| cacheCommand | Name of the executed cache command (common values are `system`, `page`, …)                                   |
| pageUid      | If the executed cache command is `page`, this marker contains the uid of the page of which cache was cleared |

For this event, you can select which cache command you want to listen to:

![Cache command selection][cache-command]

---

[:books: Documentation index](../README.md)

[cache-command]: ../../../Images/Events/clear-cache-options.png
