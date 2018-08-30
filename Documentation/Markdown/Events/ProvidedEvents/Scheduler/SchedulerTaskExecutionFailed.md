# Scheduler task failed

This event is fired when a scheduler task failed.

You can use the following properties in your notifications:

| Property    | Description                                                       |
|-------------|-------------------------------------------------------------------|
| uid         | Uid of the task, for instance `123`                               |
| title       | Title of the task, for instance `Reporting`                       |
| description | Description of the task                                           |
| data        | Arbitrary data that can be filled by the task and used as markers |
| exception   | The exception thrown during the task process                      |

---

[:books: Documentation index](../README.md)
