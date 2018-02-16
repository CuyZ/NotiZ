# ![NotiZ](ext_icon.svg) NotiZ – ChangeLog

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
