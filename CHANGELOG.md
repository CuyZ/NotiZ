# ![NotiZ](ext_icon.svg) NotiZ – ChangeLog

v0.4.0 - 01 Mar 2018
====================

New features
------------

 - **[FEATURE] Introduce event for submission of forms from core extension ([#62](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/62))**

   >*[e3c611e](https://github.com/CuyZ/NotiZ/commit/e3c611e63e322c3d44973d5834e75ef0a5a90854) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 01 Mar 2018*

   Adds a new finisher "Dispatch a notification" that can be added to a 
   form definition (accessible in the form editor backend module).
   
   A new event "A form was submitted" is now accessible for
   notifications, and provides several markers as well as email recipients
   based on the submitted form values.

 - **[FEATURE] Introduce `PropertyDefinitionBuilder` interface ([#61](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/61))**

   >*[cacfa22](https://github.com/CuyZ/NotiZ/commit/cacfa22c3de9d853c2c233e256b6ff20924ce757) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

   This interface must be implemented by classes intended to build
   property definitions for a given event.
    
   To create a new builder, you need to have a class with the same name
   as your event at which you append `PropertyBuilder`. The method
   `build` of your builder will then be automatically called when
   needed.
   
   Example:
   
   `MyVendor\MyExtension\Domain\Event\MyEvent` -> Event
   
   `MyVendor\MyExtension\Domain\Event\MyEventPropertyBuilder` -> Builder

 - **[FEATURE] Introduce a signal dispatched before an email is sent ([#53](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/53))**

   >*[6fe9b01](https://github.com/CuyZ/NotiZ/commit/6fe9b0108c9d07bd4e239902508ae70e356c5e6d) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 26 Feb 2018*

   If you need to do advanced modification on your mail, you can use a
   PHP signal. Register the slot in your `ext_localconf.php` file :
   
   ```php
   <?php
   // my_extension/ext_localconf.php
   
   $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
   );
   
   $dispatcher->connect(
      \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
     
   \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::COMPONENTS_SIGNAL,
   
      \Vendor\MyExtension\Service\Mail\MailTransformer::class,
      'registerDefinitionComponents'
   );
   ```
   
    Then modify your mail object as you need:
   
   ```php
   <?php
   // my_extension/Classes/Service/Mail/MailTransformer.php

    namespace Vendor\MyExtension\Service\Mail;
 
    use CuyZ\Notiz\Core\Channel\Payload;
    use TYPO3\CMS\Core\Mail\MailMessage;
    use TYPO3\CMS\Core\SingletonInterface;
    use TYPO3\CMS\Core\Utility\GeneralUtility;
 
    class MailTransformer implements SingletonInterface
    {
        /**
         * @param MailMessage $mailMessage
         * @param Payload $payload
         */
        public function transform(MailMessage $mailMessage, Payload $payload)
        {
            $applicationContext = GeneralUtility::getApplicationContext();
            
            // We don't change anything in production.
            if ($applicationContext->isProduction()) {
                return;
            }
            
            // Add a prefix to the mail subject, containing the application context.
            $subject = "[$applicationContext][NotiZ] " . $mailMessage->getSubject();
            $mailMessage->setSubject($subject);
            
            // When not in production, we want the mail to be sent only to us.
            $mailMessage->setTo('webmaster@acme.com');
            $mailMessage->setCc([]);
            $mailMessage->setBcc([]);
        }
   }
   ```

 - **[FEATURE] Allow event objects to give arbitrary data to notifications ([#52](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/52))**

   >*[858391b](https://github.com/CuyZ/NotiZ/commit/858391b54e236e77bc33f5b6f3a991f1d6801495) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 21 Feb 2018*

   A new interface `HasNotificationData` is introduced and can be implemented 
   by an object given to an event, when it needs to transfer arbitrary data to
   a notification during dispatching.
    
   For instance, you can implement this interface in a custom scheduler task:
   
   ```php
   <?php

   class MyCustomTask extends AbstractTask implements HasNotificationData
   {
       protected $notificationData = [];
       
       public function execute()
       {
           // Do things…
           
           $this->notificationData['foo'] = 'bar';
           
           // Do more things…
           
           return true;
       }
    
       public function getNotificationData()
       {
           return $this->notificationData;
       }
   }
   ```
   
    You can then use the marker `{data}` in your notification:
   
   `The task has been executed with "{data.foo}".`

Bugs fixed
----------

 - **[BUGFIX] Accept dash and underscore in markers syntax ([#58](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/58))**

   >*[c629888](https://github.com/CuyZ/NotiZ/commit/c6298888f43f7fb529a1a1058c5d8e14589dbbcf) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

 - **[BUGFIX] Respect language when fetching notifications ([#57](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/57))**

   >*[c06253f](https://github.com/CuyZ/NotiZ/commit/c06253f5ce0e920c4bb58f697bceac869000e658) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

 - **[BUGFIX] Register events when no backend context is found ([#55](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/55))**

   >*[6670bc0](https://github.com/CuyZ/NotiZ/commit/6670bc0b462f628be0f9a7f374c9ab8e4a96d404) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 26 Feb 2018*

 - **[BUGFIX] Detect definition error before TCA array is built ([#54](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/54))**

   >*[b561942](https://github.com/CuyZ/NotiZ/commit/b5619423cbfcbfe5e8482890656ae0e667a86ea7) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 26 Feb 2018*

   Prevents fatal error being thrown in the backend when a definition
   error is found.

Others
------

 - [[2f4cc7c](https://github.com/CuyZ/NotiZ/commit/2f4cc7c2d3c64e9d66facb6a631405da5178cb58)] **[TASK] Update changelog script ([#65](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/65))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 01 Mar 2018*

 - [[54bf3ee](https://github.com/CuyZ/NotiZ/commit/54bf3ee2f5dd2fabbcbcb571e8bce113b1dbc4f6)] **[TASK] Configure Code Climate checks ([#64](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/64))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 28 Feb 2018*

 - [[927f95c](https://github.com/CuyZ/NotiZ/commit/927f95c417093412a3030689338ebb14297a6fe7)] **[TASK] Add reST documentation index ([#63](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/63))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 28 Feb 2018*

 - [[b8fbdf3](https://github.com/CuyZ/NotiZ/commit/b8fbdf3c8cc3a7b2a69f8b8bb3dae6110c3ef9fd)] **[TASK] Make notification accessible in property definition build ([#60](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/60))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

 - [[4fcae8a](https://github.com/CuyZ/NotiZ/commit/4fcae8aca73abec0e02be092e6ae208cec0f858c)] **[TASK] Build event with notification entry ([#59](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/59))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

 - [[6c51f13](https://github.com/CuyZ/NotiZ/commit/6c51f1356fde64ee0d1c942545393556fd522c48)] **[TASK] Refactor and cleanup TCA declaration ([#56](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/56))** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 27 Feb 2018*

----

v0.3.0 - 16 Feb 2018
====================

New features
------------

 - **Enhance `slot.render` view-helper ([#44](https://github.com/CuyZ/NotiZ/issues/44))**
 
   >*[95552e6](https://github.com/CuyZ/NotiZ/commit/95552e6704ad3010136aaff49e23847b3c77e118) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 16 Feb 2018*
   
   This view-helper can now use two new features, for a total of three ways
   to render a slot.
   
   **Inline**
   
   The processed slot value will be returned.
   
   ```html
   <nz:slot.render name="MySlot"
                   markers="{foo: 'bar'}" />
   ```
   
   **Conditional**
   
   Can be used to check whether the slot exists, and do something if it
   doesn't. When using this way, a variable `slotValue` becomes accessible
   within the view-helper, that contains the processed value of the slot.
   However, this variable is filled only when the slot exists and can be
   processed.
   
   ```html
   <nz:slot.render name="SomeOptionalSlot">
       <f:then>
           {slotValue -> f:format.html()}
       </f:then>
       <f:else>
           Some default value
       </f:else>
   </nz:slot.render>
   ```
   
   **Wrapping**
   
   You may need to add HTML around the slot value only when the slot
   exists.
   
   ```html
   <nz:slot.render name="SomeOptionalSlot">
       <hr />
       <div class="some-class">
           {slotValue}
       </div>
   </nz:slot.render>
   ```

 - **Allow RTE mode in text slot ([#46](https://github.com/CuyZ/NotiZ/issues/46))**

   >*[4595aae](https://github.com/CuyZ/NotiZ/commit/4595aae7ca8a5493c97e72b3d352214db14df673) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 13 Feb 2018*
   
   Text slots can now use RTE mode like this:
   
   ```html
   <nz:slot.text name="MySlot"
                 label="My slot"
                 rte="true"
                 rteMode="my-ckeditor-preset" />
   ```
   
   You can use your own CKEditor preset by filling the argument `rteMode`.
   
   Don't forget to wrap the rendering of your slot like this:
   
   ```html
   <f:format.html>
       <nz:slot.render name="MySlot" />
   </f:format.html>
   ```
   
   A legacy mode is also introduced, allowing old configuration from
   EXT:rtehtmlarea to work as well in the `rteMode` argument.

---

Breaking changes
----------------

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

 - **Change PHP classes architecture ([#47](https://github.com/CuyZ/NotiZ/issues/47))**

   >*[20e07bb](https://github.com/CuyZ/NotiZ/commit/20e07bbe7381d4898d39719833230bcf3f597ac7) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 13 Feb 2018*

   A new folder level has been added, to ease the code readability.
   
   You should check if your code does rely on classes that have been moved!
   
 - **Change definition namespace ([#45](https://github.com/CuyZ/NotiZ/issues/45))**

   >*[5e05bed](https://github.com/CuyZ/NotiZ/commit/5e05bed904a242a978d42aa32f075230f4890d37) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 13 Feb 2018*
   
   The namespace root for NotiZ definition has been changed from
   `config.tx_notiz` to `notiz`
   
   For instance, events may now be added to the definition by using the
   following namespace: `notiz.eventGroups.myGroup.events.myEvent`

Bugs fixed
----------

 - **Render non-existing markers as an empty string ([#49](https://github.com/CuyZ/NotiZ/issues/49))**
 
   >*[e48a8ec](https://github.com/CuyZ/NotiZ/commit/e48a8ec9f889f1deebed9f94f305330338a20b19) by [Nathan Boiron](mailto:nathan.boiron@gmail.com) – 16 Feb 2018*

 - **Register notifications icons only once ([#48](https://github.com/CuyZ/NotiZ/issues/48))**
 
   >*[29e0042](https://github.com/CuyZ/NotiZ/commit/29e004201723c1340b97a6dea1578878c1af7d02) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 14 Feb 2018*

Others
------

 - [[7e0f402](https://github.com/CuyZ/NotiZ/commit/7e0f402555e8df373b640e806647ddfabc917707)] **[DOC] Fix event name (#43)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 11 Feb 2018*

---

v0.2.0 - 03 Feb 2018
====================

New features
------------

 - **Introduce slots for dynamic body in mail notification ([#35](https://github.com/CuyZ/NotiZ/issues/35))**

   >*[a6c7f1a](https://github.com/CuyZ/NotiZ/commit/a6c7f1ae7c2dba6d8e525216063d1525b907fc5f) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

   With this feature, the body section of the mail notification can now
   be composed of dynamic fields, that are managed by so-called "slots".
   This allows editors to handle several sections of the mail body,
   while the templating itself stays in the Fluid view.

   The slots can be registered in the template of the mail, in a Fluid 
   section named `Slots`. Two view-helpers are provided out of the box:

   - `<nz:slot.text>` will register a new textarea field.
   - `<nz:slot.input>` will register a new text-input field.

   Because the registration happens in Fluid, basic operations like
   loops and conditions can be used.

   Slots can then be rendered within the template by using the following 
   view-helper: `<nz:slot.render>`. Additional markers may be added to
   the slot by using the arguments `markers`.

   See documentation for more information about this feature.

 - **Change the marker syntax from `#FOO#` to `{foo}`**

   >*[71b30ab](https://github.com/CuyZ/NotiZ/commit/71b30ab25dd74b94856aed7ea7870ed6f1911000) by [Nathan Boiron](mailto:nathan.boiron@gmail.com) – 31 Jan 2018*

   Also adds support for dotted path syntax, meaning sub-values can be 
   accessed. For instance `{foo.bar}` will return the value of the `bar` 
   property of the `foo` object/array.

---

Bugs fixed
----------

 - **Catch exception when resolving email notification template ([#30](https://github.com/CuyZ/NotiZ/issues/30))**

   >*[f4fb42e](https://github.com/CuyZ/NotiZ/commit/f4fb42e8d3e4d6a3bae3134c39202c3a2a8e2d91) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

   An exception occurred in TYPO3 v7.6 instances.

 - **Prevent full localization path from being returned ([#32](https://github.com/CuyZ/NotiZ/issues/32))**

   >*[755a0bb](https://github.com/CuyZ/NotiZ/commit/755a0bb143605bb840b9b00508a31fc661038c2b) by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

   When the localization service has not been initialized yet, the value 
   returned is the full path to the translation key, not `null`. We need
   to check that in order not to return a wrong value.

Others
------

 - [[e0721a4](https://github.com/CuyZ/NotiZ/commit/e0721a4b8576b2f18fa5ac86afc29d179f7e941e)] **[TASK] Force EOL for file to `lf` (#39)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 03 Feb 2018*

 - [[ebf0cd2](https://github.com/CuyZ/NotiZ/commit/ebf0cd27f1ae90b43f75633c069df77b743f3c28)] **[TASK] Introduce update script for the changelog file (#38)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 03 Feb 2018*

 - [[4123174](https://github.com/CuyZ/NotiZ/commit/41231742e7044ae01ebcbdffae2304726830bd4c)] **[TASK] Change copyright year to 2018 (#37)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

 - [[53adc33](https://github.com/CuyZ/NotiZ/commit/53adc3320ce1c2f6bdb61b4c730ba745854b831a)] **[TASK] Add custom configuration for CodeClimate (#36)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

 - [[97c47b4](https://github.com/CuyZ/NotiZ/commit/97c47b4cef805e02436626244aef213e41c90f57)] **[DOC] Fix PHP file path (#22)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

 - [[4692bd2](https://github.com/CuyZ/NotiZ/commit/4692bd243ddaf8ae35a7490f9c106eb98edda582)] **[TASK] Make notifications `event` and `channel` fields required (#34)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

 - [[04c86c2](https://github.com/CuyZ/NotiZ/commit/04c86c2dbda060b721320274de4ffc8f31c8162f)] **[TASK] Make `MarkerParser` a singleton (#33)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 02 Feb 2018*

 - [[16bd2b0](https://github.com/CuyZ/NotiZ/commit/16bd2b0f0c0879a230e43c7381ad7b3e32c9371a)] **[DOC] Add documentation for custom event template in mail notification (#29)** – *by [Romain Canon](mailto:romain.hydrocanon@gmail.com) – 29 Jan 2018*

v0.1.0 - 2018-01-21
===================

Initial release.
