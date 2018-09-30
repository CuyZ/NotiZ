# ![NotiZ](ext_icon.svg) NotiZ – ChangeLog

## v0.5.0 - 26 April 2018

### New features

<details>
<summary>Introduce Slack notification type</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Apr 2018 / [6454dbe](https://github.com/CuyZ/NotiZ/commit/6454dbe85da09d6e44d549326549461c1f54ab7b) / [#75](https://github.com/CuyZ/NotiZ/issues/75)*

> This new notification type can be used in the TYPO3 backend in the same 
> way as the email and log notifications.
> 
> You may send your messages in channels or to specific users of your 
> Slack instance, whenever any pre-configured event is triggered and 
> dispatched by NotiZ.
> 
> You will need to properly configure the definition to bind your Slack 
> instance with NotiZ, please read documentation for more details.
> 
> Co-authored-by: Simon Praetorius <simon@praetorius.me>
</details>

<details>
<summary>Introduce signal dispatched when definition is built</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *11 Mar 2018 / [c1d3e70](https://github.com/CuyZ/NotiZ/commit/c1d3e70eaeef58488189f87c534908f3fd04bd56) / [#71](https://github.com/CuyZ/NotiZ/issues/71)*

> You may need to use NotiZ definition to initialize things in your own
> extension.
> 
> A signal will be dispatched when the definition object is complete,
> **only when no error was found when it was built**.
> 
> Note that you won't be able to modify the definition, only access its
> values.
> 
> More information in the documentation.
</details>

### Bugs fixed

<details>
<summary>Fix edition of disabled notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *26 Apr 2018 / [c94f370](https://github.com/CuyZ/NotiZ/commit/c94f370d952b10ee738dcd13159aed0795e1328d) / [#76](https://github.com/CuyZ/NotiZ/issues/76)*

> The notifications that were disabled in the backend were showing a fatal
> error on edition.
> 
> This commit fixes the issue and disabled notifications can now be edited
> properly again.
</details>

### Important

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

<details>
<summary>Separate properties handling from events</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *25 Apr 2018 / [278ea81](https://github.com/CuyZ/NotiZ/commit/278ea81f6b95cbc152560d66abb44729336cc01f) / [#77](https://github.com/CuyZ/NotiZ/issues/77)*

> Some events may exist without the need of having properties handling.
> 
> Methods in the event interface concerning the properties have been moved
> to a new interface `HasProperties` which slightly alter how the system
> works.
> 
> This interface is implemented by default in the `AbstractEvent`, so this
> changes nothing for events that extend this class (unless they override
> old methods that have been changed/deleted).
> 
> Some major refactoring works have been made so this might break your
> installation. In this case, please read carefully the class
> documentation blocks.
> 
> **Deleted methods**
> 
> - `\CuyZ\Notiz\Core\Event\Event::getProperties`
> 
>   This method was unnecessary and won't be replaced.
> 
> - `\CuyZ\Notiz\Core\Event\Event::buildPropertyDefinition`
> 
>   A new way of building the property definition is done using:
>   `\CuyZ\Notiz\Core\Event\Support\HasProperties::getPropertyBuilder`
> 
> **Moved methods**
> 
> - `\CuyZ\Notiz\Core\Event\Event::fillPropertyEntries`
> 
>   This method has been moved to:
>   `\CuyZ\Notiz\Core\Event\Support\HasProperties::fillPropertyEntries`
> 
> **Moved classes**
> 
> - `\CuyZ\Notiz\Core\Property\Support\PropertyBuilder`
> 
>   This class has been moved to:
>   `\CuyZ\Notiz\Core\Property\Builder\PropertyBuilder`
</details>

### Others

<details>
<summary>Add documentation for email annotation</summary>

> *by [Lukas Niestroj](mailto:niestrojlukas@gmail.com)* on *14 Mar 2018 / [5ff61f4](https://github.com/CuyZ/NotiZ/commit/5ff61f496abeb25e4fee01b35af1de657677c980) / [#73](https://github.com/CuyZ/NotiZ/issues/73)*

> 
</details>

<details>
<summary>Add documentation for signals sent by the extension</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *09 Mar 2018 / [687d8f9](https://github.com/CuyZ/NotiZ/commit/687d8f9e4e56daf1fdecbbf398dd840525e7f594) / [#69](https://github.com/CuyZ/NotiZ/issues/69)*

> 
</details>

<details>
<summary>Fix signal name in example</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *09 Mar 2018 / [6fc8753](https://github.com/CuyZ/NotiZ/commit/6fc87537f383d787427a4fa4d9f4c2085f44feba) / [#68](https://github.com/CuyZ/NotiZ/issues/68)*

> 
</details>

<details>
<summary>Fix images paths in README file</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *04 Mar 2018 / [cd36f7d](https://github.com/CuyZ/NotiZ/commit/cd36f7d1841d8f1ecc2b8180be08f06cbfc80d98) / [#67](https://github.com/CuyZ/NotiZ/issues/67)*

> 
</details>

## v0.4.0 - 01 March 2018

### New features

<details>
<summary>Introduce event for submission of forms from core extension</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *01 Mar 2018 / [e3c611e](https://github.com/CuyZ/NotiZ/commit/e3c611e63e322c3d44973d5834e75ef0a5a90854) / [#62](https://github.com/CuyZ/NotiZ/issues/62)*

> Adds a new finisher "Dispatch a notification" that can be added to a
> form definition (accessible in the form editor backend module).
> 
> A new event "A form was submitted" is now accessible for notifications,
> and provides several markers as well as email recipients based on
> the submitted form values.
</details>

<details>
<summary>Introduce <code>PropertyDefinitionBuilder</code> interface</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [cacfa22](https://github.com/CuyZ/NotiZ/commit/cacfa22c3de9d853c2c233e256b6ff20924ce757) / [#61](https://github.com/CuyZ/NotiZ/issues/61)*

> This interface must be implemented by classes intended to build property
> definitions for a given event.
> 
> To create a new builder, you need to have a class with the same name as
> your event at which you append `PropertyBuilder`. The method `build` of
> your builder will then be automatically called when needed.
> 
> Example:
> 
> `MyVendor\MyExtension\Domain\Event\MyEvent` -> Event
> `MyVendor\MyExtension\Domain\Event\MyEventPropertyBuilder` -> Builder
</details>

<details>
<summary>Introduce a signal dispatched before an email is sent</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *26 Feb 2018 / [6fe9b01](https://github.com/CuyZ/NotiZ/commit/6fe9b0108c9d07bd4e239902508ae70e356c5e6d) / [#53](https://github.com/CuyZ/NotiZ/issues/53)*

> If you need to do advanced modification on your mail, you can use a PHP
> signal. Register the slot in your `ext_localconf.php` file :
> 
> ```php
> <?php
> // my_extension/ext_localconf.php
> 
> $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
>     \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
> );
> 
> $dispatcher->connect(
>     \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
>     \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::COMPONENTS_SIGNAL,
>     \Vendor\MyExtension\Service\Mail\MailTransformer::class,
>     'registerDefinitionComponents'
> );
> ```
> 
> Then modify your mail object as you need:
> 
> ```php
> <?php
> // my_extension/Classes/Service/Mail/MailTransformer.php
> 
> namespace Vendor\MyExtension\Service\Mail;
> 
> use CuyZ\Notiz\Core\Channel\Payload;
> use TYPO3\CMS\Core\Mail\MailMessage;
> use TYPO3\CMS\Core\SingletonInterface;
> use TYPO3\CMS\Core\Utility\GeneralUtility;
> 
> class MailTransformer implements SingletonInterface
> {
>     /**
>      * @param MailMessage $mailMessage
>      * @param Payload $payload
>      */
>     public function transform(MailMessage $mailMessage, Payload $payload)
>     {
>         $applicationContext = GeneralUtility::getApplicationContext();
> 
>         // We don't change anything in production.
>         if ($applicationContext->isProduction()) {
>             return;
>         }
> 
>         // Add a prefix to the mail subject, containing the application context.
>         $subject = "[$applicationContext][NotiZ] " . $mailMessage->getSubject();
>         $mailMessage->setSubject($subject);
> 
>         // When not in production, we want the mail to be sent only to us.
>         $mailMessage->setTo('webmaster@acme.com');
>         $mailMessage->setCc([]);
>         $mailMessage->setBcc([]);
>     }
> }
> ```
</details>

<details>
<summary>Allow event objects to give arbitrary data to notifications</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *21 Feb 2018 / [858391b](https://github.com/CuyZ/NotiZ/commit/858391b54e236e77bc33f5b6f3a991f1d6801495) / [#52](https://github.com/CuyZ/NotiZ/issues/52)*

> A new interface `HasNotificationData` is introduced and can be
> implemented by an object given to an event, when it needs to transfer 
> arbitrary data to a notification during dispatching.
> 
> For instance, you can implement this interface in a custom scheduler
> task:
> 
> ```php
> class MyCustomTask extends AbstractTask implements HasNotificationData
> {
>     protected $notificationData = [];
> 
>     public function execute()
>     {
>         // Do things…
> 
>         $this->notificationData['foo'] = 'bar';
> 
>         // Do more things…
> 
>         return true;
>     }
> 
>     public function getNotificationData()
>     {
>         return $this->notificationData;
>     }
> }
> ```
> 
> You can then use the marker `{data}` in your notification:
> 
> `The task has been executed with "{data.foo}".`
</details>

### Bugs fixed

<details>
<summary>Accept dash and underscore in markers syntax</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [c629888](https://github.com/CuyZ/NotiZ/commit/c6298888f43f7fb529a1a1058c5d8e14589dbbcf) / [#58](https://github.com/CuyZ/NotiZ/issues/58)*

> 
</details>

<details>
<summary>Respect language when fetching notifications</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [c06253f](https://github.com/CuyZ/NotiZ/commit/c06253f5ce0e920c4bb58f697bceac869000e658) / [#57](https://github.com/CuyZ/NotiZ/issues/57)*

> 
</details>

<details>
<summary>Register events when no backend context is found</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *26 Feb 2018 / [6670bc0](https://github.com/CuyZ/NotiZ/commit/6670bc0b462f628be0f9a7f374c9ab8e4a96d404) / [#55](https://github.com/CuyZ/NotiZ/issues/55)*

> 
</details>

<details>
<summary>Detect definition error before TCA array is built</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *26 Feb 2018 / [b561942](https://github.com/CuyZ/NotiZ/commit/b5619423cbfcbfe5e8482890656ae0e667a86ea7) / [#54](https://github.com/CuyZ/NotiZ/issues/54)*

> Prevents fatal error being thrown in the backend when a definition error is
> found.
</details>

### Others

<details>
<summary>Update changelog script</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *01 Mar 2018 / [2f4cc7c](https://github.com/CuyZ/NotiZ/commit/2f4cc7c2d3c64e9d66facb6a631405da5178cb58) / [#65](https://github.com/CuyZ/NotiZ/issues/65)*

> Now runs in a PHP file.
</details>

<details>
<summary>Configure Code Climate checks</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Feb 2018 / [54bf3ee](https://github.com/CuyZ/NotiZ/commit/54bf3ee2f5dd2fabbcbcb571e8bce113b1dbc4f6) / [#64](https://github.com/CuyZ/NotiZ/issues/64)*

> 
</details>

<details>
<summary>Add reST documentation index</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Feb 2018 / [927f95c](https://github.com/CuyZ/NotiZ/commit/927f95c417093412a3030689338ebb14297a6fe7) / [#63](https://github.com/CuyZ/NotiZ/issues/63)*

> Will fix the rendering of the documentation on docs.typo3.org
</details>

<details>
<summary>Make notification accessible in property definition build</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [b8fbdf3](https://github.com/CuyZ/NotiZ/commit/b8fbdf3c8cc3a7b2a69f8b8bb3dae6110c3ef9fd) / [#60](https://github.com/CuyZ/NotiZ/issues/60)*

> 
</details>

<details>
<summary>Build event with notification entry</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [4fcae8a](https://github.com/CuyZ/NotiZ/commit/4fcae8aca73abec0e02be092e6ae208cec0f858c) / [#59](https://github.com/CuyZ/NotiZ/issues/59)*

> 
</details>

<details>
<summary>Refactor and cleanup TCA declaration</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *27 Feb 2018 / [6c51f13](https://github.com/CuyZ/NotiZ/commit/6c51f1356fde64ee0d1c942545393556fd522c48) / [#56](https://github.com/CuyZ/NotiZ/issues/56)*

> 
</details>

## v0.3.0 - 16 February 2018

### New features

<details>
<summary>Enhance <code>slot.render</code> view-helper</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *16 Feb 2018 / [95552e6](https://github.com/CuyZ/NotiZ/commit/95552e6704ad3010136aaff49e23847b3c77e118) / [#44](https://github.com/CuyZ/NotiZ/issues/44)*

> This view-helper can now use two new features, for a total of three ways
> to render a slot.
> 
> **Inline**
> 
> The processed slot value will be returned.
> 
> ```html
> <nz:slot.render name="MySlot"
>                 markers="{foo: 'bar'}" />
> ```
> 
> **Conditional**
> 
> Can be used to check whether the slot exists, and do something if it
> doesn't. When using this way, a variable `slotValue` becomes accessible
> within the view-helper, that contains the processed value of the slot.
> However, this variable is filled only when the slot exists and can be
> processed.
> 
> ```html
> <nz:slot.render name="SomeOptionalSlot">
>     <f:then>
>         {slotValue -> f:format.html()}
>     </f:then>
>     <f:else>
>         Some default value
>     </f:else>
> </nz:slot.render>
> ```
> 
> **Wrapping**
> 
> You may need to add HTML around the slot value only when the slot
> exists.
> 
> ```html
> <nz:slot.render name="SomeOptionalSlot">
>     <hr />
>     <div class="some-class">
>         {slotValue}
>     </div>
> </nz:slot.render>
> ```
</details>

<details>
<summary>Allow RTE mode in text slot</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *13 Feb 2018 / [4595aae](https://github.com/CuyZ/NotiZ/commit/4595aae7ca8a5493c97e72b3d352214db14df673) / [#46](https://github.com/CuyZ/NotiZ/issues/46)*

> Text slots can now use RTE mode like this:
> 
> ```html
> <nz:slot.text name="MySlot"
>               label="My slot"
>               rte="true"
>               rteMode="my-ckeditor-preset" />
> ```
> 
> You can use your own CKEditor preset by filling the argument `rteMode`.
> 
> Don't forget to wrap the rendering of your slot like this:
> 
> ```html
> <f:format.html>
>     <nz:slot.render name="MySlot" />
> </f:format.html>
> ```
> 
> A legacy mode is also introduced, allowing old configuration from
> EXT:rtehtmlarea to work as well in the `rteMode` argument.
> 
> Closes [#24](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/24)
</details>

### Bugs fixed

<details>
<summary>Render non-existing markers as an empty string</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *16 Feb 2018 / [e48a8ec](https://github.com/CuyZ/NotiZ/commit/e48a8ec9f889f1deebed9f94f305330338a20b19) / [#49](https://github.com/CuyZ/NotiZ/issues/49)*

> 
</details>

<details>
<summary>Register notifications icons only once</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *14 Feb 2018 / [29e0042](https://github.com/CuyZ/NotiZ/commit/29e004201723c1340b97a6dea1578878c1af7d02) / [#48](https://github.com/CuyZ/NotiZ/issues/48)*

> 
</details>

### Important

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

<details>
<summary>Change PHP classes architecture</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *13 Feb 2018 / [20e07bb](https://github.com/CuyZ/NotiZ/commit/20e07bbe7381d4898d39719833230bcf3f597ac7) / [#47](https://github.com/CuyZ/NotiZ/issues/47)*

> A new folder level has been added, to ease the code readability.
> 
> You should check if your code does rely on classes that have been moved!
</details>

<details>
<summary>Change definition namespace</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *13 Feb 2018 / [5e05bed](https://github.com/CuyZ/NotiZ/commit/5e05bed904a242a978d42aa32f075230f4890d37) / [#45](https://github.com/CuyZ/NotiZ/issues/45)*

> The namespace root for NotiZ definition has been changed from
> `config.tx_notiz` to `notiz`
> 
> For instance, events may now be added to the definition by using the
> following namespace: `notiz.eventGroups.myGroup.events.myEvent`
> 
> Closes [#28](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/28)
</details>

### Others

<details>
<summary>Fix event name</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *11 Feb 2018 / [7e0f402](https://github.com/CuyZ/NotiZ/commit/7e0f402555e8df373b640e806647ddfabc917707) / [#43](https://github.com/CuyZ/NotiZ/issues/43)*

> 
</details>

## v0.2.0 - 03 February 2018

### New features

<details>
<summary>Introduce slots for dynamic body in mail notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [a6c7f1a](https://github.com/CuyZ/NotiZ/commit/a6c7f1ae7c2dba6d8e525216063d1525b907fc5f) / [#35](https://github.com/CuyZ/NotiZ/issues/35)*

> With this feature, the body section of the mail notification can now be
> composed of dynamic fields, that are managed by so-called "slots". This
> allows editors to handle several sections of the mail body, while the
> templating itself stays in the Fluid view.
> 
> The slots can be registered in the template of the mail, in a Fluid
> section named `Slots`. Two view-helpers are provided out of the box:
> 
> - `<nz:slot.text>` will register a new textarea field.
> - `<nz:slot.input>` will register a new text-input field.
> 
> Because the registration happens in Fluid, basic operations like loops
> and conditions can be used.
> 
> Slots can then be rendered within the template by using the following
> view-helper: `<nz:slot.render>`. Additional markers may be added to the
> slot by using the arguments `markers`.
> 
> See documentation for more information about this feature.
> 
> ---
> 
> Closes [#26](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/26)
</details>

<details>
<summary>Change the marker syntax from <code>#FOO#</code> to <code>{foo}</code></summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *31 Jan 2018 / [71b30ab](https://github.com/CuyZ/NotiZ/commit/71b30ab25dd74b94856aed7ea7870ed6f1911000)*

> Also adds support for dotted path syntax, meaning sub-values can be
> accessed. For instance `{foo.bar}` will return the value of the `bar`
> property of the `foo` object/array.
</details>

### Bugs fixed

<details>
<summary>Catch exception when resolving email notification template</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [f4fb42e](https://github.com/CuyZ/NotiZ/commit/f4fb42e8d3e4d6a3bae3134c39202c3a2a8e2d91) / [#30](https://github.com/CuyZ/NotiZ/issues/30)*

> An exception occurred in TYPO3 v7.6 instances.
</details>

<details>
<summary>Prevent full localization path from being returned</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [755a0bb](https://github.com/CuyZ/NotiZ/commit/755a0bb143605bb840b9b00508a31fc661038c2b) / [#32](https://github.com/CuyZ/NotiZ/issues/32)*

> When the localization service has not been initialized yet, the value
> returned is the full path to the translation key, not `null`. We need to
> check that in order not to return a wrong value.
</details>

### Others

<details>
<summary>Force EOL for file to <code>lf</code></summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *03 Feb 2018 / [e0721a4](https://github.com/CuyZ/NotiZ/commit/e0721a4b8576b2f18fa5ac86afc29d179f7e941e) / [#39](https://github.com/CuyZ/NotiZ/issues/39)*

> 
</details>

<details>
<summary>Introduce update script for the changelog file</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *03 Feb 2018 / [ebf0cd2](https://github.com/CuyZ/NotiZ/commit/ebf0cd27f1ae90b43f75633c069df77b743f3c28) / [#38](https://github.com/CuyZ/NotiZ/issues/38)*

> 
</details>

<details>
<summary>Change copyright year to 2018</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [4123174](https://github.com/CuyZ/NotiZ/commit/41231742e7044ae01ebcbdffae2304726830bd4c) / [#37](https://github.com/CuyZ/NotiZ/issues/37)*

> Happy new year! 🍾
> 
> (sorry I'm late)
</details>

<details>
<summary>Add custom configuration for CodeClimate</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [53adc33](https://github.com/CuyZ/NotiZ/commit/53adc3320ce1c2f6bdb61b4c730ba745854b831a) / [#36](https://github.com/CuyZ/NotiZ/issues/36)*

> 
</details>

<details>
<summary>Fix PHP file path</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [97c47b4](https://github.com/CuyZ/NotiZ/commit/97c47b4cef805e02436626244aef213e41c90f57) / [#22](https://github.com/CuyZ/NotiZ/issues/22)*

> 
</details>

<details>
<summary>Make notifications <code>event</code> and <code>channel</code> fields required</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [4692bd2](https://github.com/CuyZ/NotiZ/commit/4692bd243ddaf8ae35a7490f9c106eb98edda582) / [#34](https://github.com/CuyZ/NotiZ/issues/34)*

> 
</details>

<details>
<summary>Make <code>MarkerParser</code> a singleton</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 Feb 2018 / [04c86c2](https://github.com/CuyZ/NotiZ/commit/04c86c2dbda060b721320274de4ffc8f31c8162f) / [#33](https://github.com/CuyZ/NotiZ/issues/33)*

> 
</details>

<details>
<summary>Add documentation for custom event template in mail notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Jan 2018 / [16bd2b0](https://github.com/CuyZ/NotiZ/commit/16bd2b0f0c0879a230e43c7381ad7b3e32c9371a) / [#29](https://github.com/CuyZ/NotiZ/issues/29)*

> 
</details>

## v0.1.0 - 21 January 2018

Initial release.
