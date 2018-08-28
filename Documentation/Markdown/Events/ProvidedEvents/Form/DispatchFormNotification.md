# Form finisher

> /!\ For this event, you need to have [TYPO3 v8.5][form-changelog] minimum and the [Form][form-extension] extension installed and active.

This event is triggered when a form that implements the notification dispatch
finisher is submitted.

The finisher class is `\CuyZ\Notiz\Domain\Event\Form\DispatchFormNotificationFinisher`.

You can use the following properties in your notifications:

| Property          | Description                                                       |
|-------------------|-------------------------------------------------------------------|
| formValues        | Form values submitted by the user                                 |
| formRuntime       | Runtime object of the form, contains a lot of useful information  |
| controllerContext | Current controller context that led to the submission of the form |

---

[:books: Documentation index](../README.md)

[form-changelog]: https://docs.typo3.org/typo3cms/extensions/core/Changelog/8.5/Feature-77910-EXTform-IntroduceNewFormFramework.html
[form-extension]: https://docs.typo3.org/typo3cms/extensions/form/Index.html
