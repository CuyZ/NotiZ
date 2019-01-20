# ![NotiZ](ext_icon.svg) NotiZ – ChangeLog

## v1.1.0 - 20 January 2019

> ℹ️ *Click on a changelog entry to see more details.*

### New features

<details>
<summary>Assign notification and event instances to email view</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *21 Dec 2018 / [af8cb88](https://github.com/CuyZ/NotiZ/commit/af8cb881221ca2e777aad5d4d5cd3c6205eada19) / [#176](https://github.com/CuyZ/NotiZ/issues/176)*

> Two new variables become accessible in the template of an email:
> 
> - `{notification}` – contains the notification instance
> - `{event}` – contains the event instance
</details>

<details>
<summary>Handle priority for file definition sources</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *21 Dec 2018 / [911c135](https://github.com/CuyZ/NotiZ/commit/911c1359be3aebdb119891fc12f7bbf5c585beea) / [#173](https://github.com/CuyZ/NotiZ/issues/173)*

> The file definition sources are now sorted by the priority they are
> given.
> 
> Default definition files have a high priority, to easily allow other
> files to override definition values.
</details>

### Bugs fixed

<details>
<summary>Distinct TCA processors and data providers</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *20 Jan 2019 / [a339bf1](https://github.com/CuyZ/NotiZ/commit/a339bf1604779a7591b80b2b50230e62dc380d4e) / [#184](https://github.com/CuyZ/NotiZ/issues/184)*

> Some data providers were actually not acting on an actual notification
> record, but modifying global TCA configuration instead.
> 
> Because of this, TYPO3 core would misunderstand things, like FlexForm
> configuration done dynamically. This would result in strange behaviour
> like empty paragraph added on text columns with RTE inside FlexForm
> fields.
> 
> This commit separates these processors in a distinct namespace, with a
> brand new role and interface.
> 
> Fixes [#181](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/181)
</details>

<details>
<summary>Show message when CKEditor preset is missing in slot</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *20 Jan 2019 / [fb61c9b](https://github.com/CuyZ/NotiZ/commit/fb61c9b50110ba9416b58f3df3de5ff90afcec0a) / [#182](https://github.com/CuyZ/NotiZ/issues/182)*

> 
</details>

<details>
<summary>Make email property handle multiple email addresses</summary>

> *by [ogrosko](mailto:ogrosko@gmail.com)* on *18 Dec 2018 / [82a78b9](https://github.com/CuyZ/NotiZ/commit/82a78b9cea8783afb03b7bf4e3dc40c12a02c6f9) / [#171](https://github.com/CuyZ/NotiZ/issues/171)*

> closes [#170](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/170)
</details>

### Others

<details>
<summary>Add documentation on how to add custom config to events</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *20 Jan 2019 / [9296c10](https://github.com/CuyZ/NotiZ/commit/9296c1073d0a67ec91813fb2d0a8f3c9510b19cb) / [#185](https://github.com/CuyZ/NotiZ/issues/185)*

> 
</details>

<details>
<summary>Fix wrong locallang references for scheduler events</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *20 Jan 2019 / [9fba3d5](https://github.com/CuyZ/NotiZ/commit/9fba3d5daa99e499d02dffa238e8fcf2550c53ac) / [#183](https://github.com/CuyZ/NotiZ/issues/183)*

> 
</details>

<details>
<summary>Hide columns of notification entity when no event is selected</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *20 Jan 2019 / [cf28edd](https://github.com/CuyZ/NotiZ/commit/cf28eddae73c6d6b843c82d9797a962586f6419b) / [#178](https://github.com/CuyZ/NotiZ/issues/178)*

> Closes [#31](https:\/\/github.com\/CuyZ\/NotiZ\/issues\/31)
</details>

<details>
<summary>Change line feeds in localization files</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *20 Jan 2019 / [a35699e](https://github.com/CuyZ/NotiZ/commit/a35699edea32ccfd0a1af7b7daedbfcd19987717) / [#177](https://github.com/CuyZ/NotiZ/issues/177)*

> 
</details>

<details>
<summary>Fix a typo in the admin module language file</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *21 Dec 2018 / [6282982](https://github.com/CuyZ/NotiZ/commit/628298206d1b0e95b99b59d9b8c5cffa0fe8c9ce) / [#175](https://github.com/CuyZ/NotiZ/issues/175)*

> 
</details>

<details>
<summary>Add <code>.idea</code> to <code>.gitignore</code></summary>

> *by [ogrosko](mailto:ogrosko@gmail.com)* on *18 Dec 2018 / [9ca335d](https://github.com/CuyZ/NotiZ/commit/9ca335d3acd259a262ed39e49b971faccfb4f64f) / [#172](https://github.com/CuyZ/NotiZ/issues/172)*

> 
</details>

## v1.0.1 - 11 December 2018

> ℹ️ *Click on a changelog entry to see more details.*
### Others

<details>
<summary>Fix documentation settings and build warnings</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *11 Dec 2018 / [947af7e](https://github.com/CuyZ/NotiZ/commit/947af7e5ce5cc4f779826e1b1593b013d4f00823) / [#167](https://github.com/CuyZ/NotiZ/issues/167)*

> 
</details>

## v1.0.0 - 10 December 2018

> ℹ️ *Click on a changelog entry to see more details.*

### New features

<details>
<summary>Handle disabled notifications in the manager</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *26 nov 2018 / [eb40888](https://github.com/CuyZ/NotiZ/commit/eb408888ac5abb8d337b68a26e4364d4bd1e23b4) / [#159](https://github.com/CuyZ/NotiZ/issues/159)*

> 
</details>

<details>
<summary>Filter notifications by event and show a clear button</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *20 nov 2018 / [c2c83c6](https://github.com/CuyZ/NotiZ/commit/c2c83c6f3fdec122d17b2b7df6aff16fac3a0bd8) / [#158](https://github.com/CuyZ/NotiZ/issues/158)*

> 
</details>

<details>
<summary>Introduce simple definition file registration</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *12 nov 2018 / [444a2bb](https://github.com/CuyZ/NotiZ/commit/444a2bb01bf8b46f5fcbd0efc792c168cf721eb2) / [#151](https://github.com/CuyZ/NotiZ/issues/151)*

> Files containing definition values can now be added in a dramatically
> more simple way: registering a definition component service is not
> absolutely needed anymore.
> 
> One can just add the following piece of code to the `ext_localconf.php`
> file of his/her extension:
> 
> ```
> $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][\CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::class][]
>     = 'EXT:my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript';
> ```
> 
> Please note that the following method has been renamed. Calls to this
> method must be changed as well.
> 
> ```
> \CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::addTypoScriptFilePath($path)
> ```
> 
> now becomes:
> 
> ```
> \CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::addFilePath($path)
> ```
</details>

### Bugs fixed

<details>
<summary>Forward to correct controller when an event is not found</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *06 déc 2018 / [ef0032a](https://github.com/CuyZ/NotiZ/commit/ef0032a62fefa067c851eec22dddb86b7061e27e) / [#165](https://github.com/CuyZ/NotiZ/issues/165)*

> 
</details>

<details>
<summary>Correctly check if notification entity is editable</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *06 déc 2018 / [3e832c4](https://github.com/CuyZ/NotiZ/commit/3e832c4a404b137f28d76af07017339a5235bd4f) / [#163](https://github.com/CuyZ/NotiZ/issues/163)*

> 
</details>

<details>
<summary>Prevent toolbar Ajax request to run again when it failed</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 nov 2018 / [30a51b0](https://github.com/CuyZ/NotiZ/commit/30a51b0b7fd2d8cc4cd615bb4a8f1bd27356b698) / [#161](https://github.com/CuyZ/NotiZ/issues/161)*

> In order to prevent potential error log spamming, when the toolbar Ajax
> request fails, it won't automatically run again.
</details>

<details>
<summary>Fix the activation link generation</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *26 nov 2018 / [77a8bce](https://github.com/CuyZ/NotiZ/commit/77a8bcea0d1901b0fc11f8426bc4a388dae3e1cc) / [#160](https://github.com/CuyZ/NotiZ/issues/160)*

> 
</details>

<details>
<summary>Allow access to array values from a scalar index</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *12 nov 2018 / [801c531](https://github.com/CuyZ/NotiZ/commit/801c531f47cb2be7cef4962297ed033bc64c70f9) / [#156](https://github.com/CuyZ/NotiZ/issues/156)*

> For an array like this:
> ```
> $data = [
>     ['foo' => 'value 0'],
>     ['foo' => 'value 1'],
> ];
> ```
> 
> It is now possible to use this marker: `{data.0.foo}`
</details>

<details>
<summary>Use correct display-condition syntax for TYPO3 v8</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *12 nov 2018 / [e49cebf](https://github.com/CuyZ/NotiZ/commit/e49cebfa4306a367255e2870649fd293b605215c) / [#152](https://github.com/CuyZ/NotiZ/issues/152)*

> 
</details>

<details>
<summary>Move body slots TCA to graceful data provider</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *25 oct 2018 / [47dc15e](https://github.com/CuyZ/NotiZ/commit/47dc15e317ec19d49b8a68c8a8bb3fc706332eca) / [#148](https://github.com/CuyZ/NotiZ/issues/148)*

> Prevents a crash of the whole TYPO3 backend under certain circumstances.
</details>

<details>
<summary>Handle empty form finisher list</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *24 oct 2018 / [662d569](https://github.com/CuyZ/NotiZ/commit/662d5696ba839659a2f8214e76e378ebd36e68b1) / [#147](https://github.com/CuyZ/NotiZ/issues/147)*

> 
</details>

<details>
<summary>Move event configuration TCA to graceful data provider</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *24 oct 2018 / [4d07418](https://github.com/CuyZ/NotiZ/commit/4d07418e71457a2cc4528c37b7f34610f78afcc9) / [#146](https://github.com/CuyZ/NotiZ/issues/146)*

> Prevents a crash of the whole TYPO3 backend under certain circumstances.
</details>

<details>
<summary>Set the default value of <code>custom_bot</code> column to <code>1</code></summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *06 oct 2018 / [3c13e9f](https://github.com/CuyZ/NotiZ/commit/3c13e9ff9663cd523593e04b9b6acf5c5389b5d0) / [#140](https://github.com/CuyZ/NotiZ/issues/140)*

> When there are no configured Slack bot, the `custom_bot` checkbox does
> not appear and is set to `false`. The custom bot could not be detected.
</details>

### Important

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

<details>
<summary>Merge languages files</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *06 déc 2018 / [6c50b84](https://github.com/CuyZ/NotiZ/commit/6c50b848cc6efad7f8afc5d281e0574512215250) / [#164](https://github.com/CuyZ/NotiZ/issues/164)*

> The project started to have too many language files and it became hard
> to understand where to put translations.
> 
> Other languages were removed to instead use the TYPO3 translation
> server: https://translation.typo3.org/
</details>

<details>
<summary>Remove definition components identifier</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *25 oct 2018 / [a9c836b](https://github.com/CuyZ/NotiZ/commit/a9c836bac284c571ca12a59456c65706db7a83c1) / [#150](https://github.com/CuyZ/NotiZ/issues/150)*

> Adding new definition components (source or processor) doesn't require
> an identifier anymore.
> 
> Because these components are actually classes that must implement their
> own interfaces, the class name itself is a unique identifier.
> 
> Current code that uses the following methods should remove the first
> parameter and leave the second one:
> 
> ```
> \CuyZ\Notiz\Core\Definition\Builder\Component\DefinitionComponents::addSource($className)
> \CuyZ\Notiz\Core\Definition\Builder\Component\DefinitionComponents::addProcessor($className)
> ```
</details>

### Others

<details>
<summary>Rewrite documentation to RST format</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *10 déc 2018 / [9f514b5](https://github.com/CuyZ/NotiZ/commit/9f514b502e83c811e98ff065bd152771dba2da3e) / [#162](https://github.com/CuyZ/NotiZ/issues/162)*

> Co-authored-by: Nathan Boiron <nathan.boiron@gmail.com>
</details>

<details>
<summary>Use new marker syntax</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *25 oct 2018 / [d163c65](https://github.com/CuyZ/NotiZ/commit/d163c6591aff1adc95cac64000c4310ec90cfa31) / [#149](https://github.com/CuyZ/NotiZ/issues/149)*

> 
</details>

<details>
<summary>Move exception details panel into partial</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 oct 2018 / [74e2834](https://github.com/CuyZ/NotiZ/commit/74e2834f0180e819c575b5688b30fe8b50f5dd9b) / [#145](https://github.com/CuyZ/NotiZ/issues/145)*

> 
</details>

<details>
<summary>Separate definition error handling in TCA</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 oct 2018 / [68f11e3](https://github.com/CuyZ/NotiZ/commit/68f11e39809ce1080da9b6961ea4ba7395048f7f) / [#144](https://github.com/CuyZ/NotiZ/issues/144)*

> Changes the way the definition error is handled within entity
> notifications.
> 
> The old way consisted in adding display conditions to every field to
> check if the definition contains error.
> 
> Now, a data provider does the same job, and replaces the whole TCA if an
> error is found.
</details>

<details>
<summary>Make exception return type consistent</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *06 oct 2018 / [5896793](https://github.com/CuyZ/NotiZ/commit/5896793c982c7aec35ac44faafabf0337b2c6d01) / [#142](https://github.com/CuyZ/NotiZ/issues/142)*

> Using `static` was not correct and would make IDE not understand the
> type of the exception in all situations.
</details>

## v0.6.0 - 01 October 2018

> ℹ️ *Click on a changelog entry to see more details.*

### New features

<details>
<summary>Add report in TYPO3 module for NotiZ</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *01 Oct 2018 / [a1f6baf](https://github.com/CuyZ/NotiZ/commit/a1f6bafe6f45f31c2ca62dee7fd5e225f8450bfc) / [#105](https://github.com/CuyZ/NotiZ/issues/105)*

> Adds an entry to the status report handled by TYPO3.
> 
> If an error is found in the definition, an error report is added to the
> queue, making it easier for administrators to see that something is
> wrong with the extension.
</details>

<details>
<summary>Introduce notification manager backend module</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *30 Sep 2018 / [e5f73be](https://github.com/CuyZ/NotiZ/commit/e5f73bedf077f04d10eedaeff75f941363609d6d) / [#135](https://github.com/CuyZ/NotiZ/issues/135)*

> This module gives access to different views, where notifications and
> events can be managed easily. The usefulness is to centralise every
> notification-related operation in a single place.
> 
> Editors can now create and edit notifications in a very simple and
> intuitive way. They can also see a detailed view of each existing
> record, including a preview area.
> 
> It is advised to configure editors right access to the new module, as
> well as their abilities to create/see every type of notification.
</details>

<details>
<summary>Introduce new view-helper to chunk an array</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [ae87c82](https://github.com/CuyZ/NotiZ/commit/ae87c82df28e87793d2f446222505c105b94b4a4) / [#115](https://github.com/CuyZ/NotiZ/issues/115)*

> 
</details>

<details>
<summary>Add asynchronous refresh to the notification toolbar</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 Sep 2018 / [1afd071](https://github.com/CuyZ/NotiZ/commit/1afd07120594162452bc05d31e58fc490e3a100e) / [#108](https://github.com/CuyZ/NotiZ/issues/108)*

> A periodic asynchronous refresh has been added to the notification
> toolbar. These Ajax request will reload notification information every
> 5 minutes in normal time, and every 30 seconds if an error occurred.
> 
> Buttons have been added in the toolbar, allowing a manual refresh.
> 
> One thing to note is that the first rendering of the toolbar (done
> during the TYPO3 backend rendering) does not contain information about
> existing notifications anymore (they will be fetched asynchronously).
> This can slightly improve performance when a lot of notifications were
> to be listed.
> 
> Co-authored-by: Nathan Boiron <nathan.boiron@gmail.com>
</details>

<details>
<summary>Add legacy backend icon view-helper</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *12 Sep 2018 / [5a20a0b](https://github.com/CuyZ/NotiZ/commit/5a20a0b1193b0b96748b2c0dbb83125d02ed76c2) / [#107](https://github.com/CuyZ/NotiZ/issues/107)*

> This view-helper is needed to stay compatible with TYPO3 v7 and v8 
> without having to check the version every time.
> 
> In TYPO3 v7: `<f:be.buttons.icon icon="foo" />`
> In TYPO3 v8: `<core:icon identifier="foo" />`
> This ViewHelper: `<nz:core.icon identifier="foo" />`
</details>

<details>
<summary>Add description column to notification entities</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *05 Sep 2018 / [6d9231b](https://github.com/CuyZ/NotiZ/commit/6d9231b4877c0b5156e2bc039e42f865baf007a7) / [#100](https://github.com/CuyZ/NotiZ/issues/100)*

> See: https://docs.typo3.org/typo3cms/TCAReference/Ctrl/Index.html#descriptioncolumn
</details>

<details>
<summary>Allow events to give example properties</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [e22f2c9](https://github.com/CuyZ/NotiZ/commit/e22f2c98dfdd6afd0e43b52e4a56c6005996708a) / [#97](https://github.com/CuyZ/NotiZ/issues/97)*

> These example properties will be used to show a preview of notifications
> using the events giving these examples.
</details>

<details>
<summary>Introduce view-helper to generate link to backend module</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [390f5e6](https://github.com/CuyZ/NotiZ/commit/390f5e64fc04c785fcd56cd11cb5555544545d3e) / [#92](https://github.com/CuyZ/NotiZ/issues/92)*

> The old `BackendUriBuilder` has been removed for a module manager to
> take its place.
> 
> This will help new incoming backend modules to have their own handlers.
</details>

<details>
<summary>Allow event definition to count notifications bound to it</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 May 2018 / [5256b85](https://github.com/CuyZ/NotiZ/commit/5256b85e4ef942f5d4f94027372d0cc57b5616bd) / [#90](https://github.com/CuyZ/NotiZ/issues/90)*

> 
</details>

<details>
<summary>Introduce signals to globally manipulate properties</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 May 2018 / [af3c379](https://github.com/CuyZ/NotiZ/commit/af3c3797d829ad9bce57e0e488c6a1de61c1fa92) / [#89](https://github.com/CuyZ/NotiZ/issues/89)*

> Can be used for instance to add markers to every notification.
> 
> See documentation for more information.
</details>

<details>
<summary>Introduce preset argument for the event of a notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *08 May 2018 / [6f0c561](https://github.com/CuyZ/NotiZ/commit/6f0c561df2dd2868609903a5f3cf576da43fedad) / [#83](https://github.com/CuyZ/NotiZ/issues/83)*

> An argument `selectedEvent` can be added to a request for the creation
> of a new notification. This will give a default value to the event of
> the notification.
</details>

<details>
<summary>Introduce <code>nl2brTrim</code> view-helper</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *08 May 2018 / [1089a65](https://github.com/CuyZ/NotiZ/commit/1089a655bccf9d4ea22dd3b0573be932242e94ac) / [#82](https://github.com/CuyZ/NotiZ/issues/82)*

> Will apply a trim on the value, then convert all new lines by an HTML
> tag `<br />`.
</details>

<details>
<summary>Add description to notification definition</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *08 May 2018 / [1e4b2d1](https://github.com/CuyZ/NotiZ/commit/1e4b2d1abba9068926aa37a1fcc9491fbc60afbb) / [#80](https://github.com/CuyZ/NotiZ/issues/80)*

> Allows getting more information about a notification.
> 
> A description text has been added for existing notifications.
</details>

<details>
<summary>Add description to event definition</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *08 May 2018 / [ffa1cbf](https://github.com/CuyZ/NotiZ/commit/ffa1cbf340d6b07f478bae143763e380f49ec778) / [#79](https://github.com/CuyZ/NotiZ/issues/79)*

> Allows getting more information about an event.
> 
> A description text has been added for existing events.
</details>

<details>
<summary>Allow getting event from full identifier in definition</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 May 2018 / [265123e](https://github.com/CuyZ/NotiZ/commit/265123e7e597e37f05ccb64396ffc3bdbe4f6759) / [#81](https://github.com/CuyZ/NotiZ/issues/81)*

> The full identifier of an event is composed of the identifier of the
> event group and the identifier of the event itself. Both are separated
> by a dot.
</details>

### Bugs fixed

<details>
<summary>Import namespace in Fluid layout</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [affb6c4](https://github.com/CuyZ/NotiZ/commit/affb6c474f878e0830cd9bab4ea35c0bec6bdaf8) / [#128](https://github.com/CuyZ/NotiZ/issues/128)*

> 
</details>

<details>
<summary>Make <code>nl2br</code> view-helper compatible with TYPO3 v7</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *26 Sep 2018 / [7bc4999](https://github.com/CuyZ/NotiZ/commit/7bc4999cc401eaa700f530a1b116cc7c62f8a090) / [#126](https://github.com/CuyZ/NotiZ/issues/126)*

> 
</details>

<details>
<summary>Move the ViewHelper class to the correct folder</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [48f7481](https://github.com/CuyZ/NotiZ/commit/48f74816817eea0861b7f29203853ce86b6d58c8) / [#123](https://github.com/CuyZ/NotiZ/issues/123)*

> 
</details>

<details>
<summary>Properly fetch Slack notification message properties</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *05 Sep 2018 / [97805e5](https://github.com/CuyZ/NotiZ/commit/97805e5ab2859ea517f17f537cbc9947acefd058) / [#103](https://github.com/CuyZ/NotiZ/issues/103)*

> 
</details>

<details>
<summary>Always return string when converting property to string</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *05 Sep 2018 / [02e23f4](https://github.com/CuyZ/NotiZ/commit/02e23f43f392e17c3c93dd37649634eac661ca0f) / [#102](https://github.com/CuyZ/NotiZ/issues/102)*

> 
</details>

<details>
<summary>Make notification entity title static</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *05 Sep 2018 / [72f38d9](https://github.com/CuyZ/NotiZ/commit/72f38d92a5b7cc839a99c1a793d30a367d377f77) / [#101](https://github.com/CuyZ/NotiZ/issues/101)*

> When an error was found in definition, the current implementation would
> not show the title of the notification; this was leading to
> misunderstanding in certain modules, for instance in a backend usergroup
> record access list.
</details>

### Important

**⚠ Please pay attention to the changes below as they might break your TYPO3 installation:** 

<details>
<summary>Add way to check if notification has event definition</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *26 Sep 2018 / [a28b914](https://github.com/CuyZ/NotiZ/commit/a28b914e7d4ed8417fda3a6becd96fd3577ddb97) / [#127](https://github.com/CuyZ/NotiZ/issues/127)*

> This patch adds a method to check if a notification has an event definition bound to it.
> 
> In addition, the getter now throws an exception if the notification doesn't have an event definition.
</details>

<details>
<summary>Make administration module accessible only for admin</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *05 Sep 2018 / [a48ee7e](https://github.com/CuyZ/NotiZ/commit/a48ee7e1279c94824e859d6a31a0373d0b7de103) / [#104](https://github.com/CuyZ/NotiZ/issues/104)*

> 
</details>

<details>
<summary>Make notification aware of the event it is bound to</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *31 May 2018 / [c86bca7](https://github.com/CuyZ/NotiZ/commit/c86bca79da065f428dc5a80ae3b9c9d2f9a5a0bb) / [#91](https://github.com/CuyZ/NotiZ/issues/91)*

> A new method is added to the notification interface, that must return
> the event definition it is bound to.
</details>

<details>
<summary>Allow counting notifications using a given event</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 May 2018 / [1d4f77f](https://github.com/CuyZ/NotiZ/commit/1d4f77fd1f78c0dd8ff2ff1df363714120e11a00) / [#88](https://github.com/CuyZ/NotiZ/issues/88)*

> A new abstract method is added to the notification processor. A default
> implementation is added for entity repositories.
</details>

<details>
<summary>Make notification aware of its definition</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *18 May 2018 / [24bdcdf](https://github.com/CuyZ/NotiZ/commit/24bdcdf83c0ba961dbd07014e3b80a2fa24d7806) / [#87](https://github.com/CuyZ/NotiZ/issues/87)*

> A new method is added to the notification interface, that must return
> the notification definition.
</details>

### Others

<details>
<summary>Update changelog format</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *01 Oct 2018 / [f489900](https://github.com/CuyZ/NotiZ/commit/f48990070f1229cfa8f2dbdfcf74ac11a722e476) / [#137](https://github.com/CuyZ/NotiZ/issues/137)*

> The format of the automatic changelog script has changed, for a better 
> rendering on GitHub.
> 
> Existing changelog entries have been updated as well.
</details>

<details>
<summary>Rename manager module handler</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *30 Sep 2018 / [6d85f7a](https://github.com/CuyZ/NotiZ/commit/6d85f7a92f0ccf9440fe83692605419fcaed68bf) / [#136](https://github.com/CuyZ/NotiZ/issues/136)*

> 
</details>

<details>
<summary>Remove untranslated localization content</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [22188ac](https://github.com/CuyZ/NotiZ/commit/22188ac95709c71118388c02c70a4b207cdb8a2d) / [#134](https://github.com/CuyZ/NotiZ/issues/134)*

> 
</details>

<details>
<summary>Allow editors to create notifications on root page</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [2ee9d93](https://github.com/CuyZ/NotiZ/commit/2ee9d933e03167bca451a94ab404d4c04857053a) / [#133](https://github.com/CuyZ/NotiZ/issues/133)*

> 
</details>

<details>
<summary>Allow module links inside TYPO3 frame</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [8d7930a](https://github.com/CuyZ/NotiZ/commit/8d7930a7e9abdf251de1c19554e20bbec9b24d39) / [#132](https://github.com/CuyZ/NotiZ/issues/132)*

> 
</details>

<details>
<summary>Apply trim on lines wrapping</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [93691d9](https://github.com/CuyZ/NotiZ/commit/93691d94a49f8b65e0b74259db21945eac7b91a8) / [#131](https://github.com/CuyZ/NotiZ/issues/131)*

> Prevents empty `<p>` tags.
</details>

<details>
<summary>Rewrite index page in administration module</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *29 Sep 2018 / [b8e7c41](https://github.com/CuyZ/NotiZ/commit/b8e7c41647b929c7bd9a64697def15e6816977a7) / [#130](https://github.com/CuyZ/NotiZ/issues/130)*

> 
</details>

<details>
<summary>Improve the formatting of multi-line strings</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *29 Sep 2018 / [9f58f53](https://github.com/CuyZ/NotiZ/commit/9f58f538a6dc72c6182bc64ea322ea8446bffbca) / [#129](https://github.com/CuyZ/NotiZ/issues/129)*

> 
</details>

<details>
<summary>Add a way to mark notifications as viewable by an editor</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [cdae4b6](https://github.com/CuyZ/NotiZ/commit/cdae4b6782d024cc920d580460a5d939c3d10962) / [#125](https://github.com/CuyZ/NotiZ/issues/125)*

> 
</details>

<details>
<summary>Add a way to mark notifications as editable by an editor</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [8ce03cb](https://github.com/CuyZ/NotiZ/commit/8ce03cb4f7089bce824c310f855b6114b614bcb1) / [#124](https://github.com/CuyZ/NotiZ/issues/124)*

> 
</details>

<details>
<summary>Add a way to mark notifications as creatable by an editor</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [8e746ea](https://github.com/CuyZ/NotiZ/commit/8e746ea084f943788121247eed68905ba33262b0) / [#122](https://github.com/CuyZ/NotiZ/issues/122)*

> 
</details>

<details>
<summary>Improve the TCA display for Slack notifications</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [e9c972a](https://github.com/CuyZ/NotiZ/commit/e9c972a817a7e2588a0bfae53ca75335991d2362) / [#121](https://github.com/CuyZ/NotiZ/issues/121)*

> 
</details>

<details>
<summary>Extract exception handling to dedicated controller</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *25 Sep 2018 / [ddad7d2](https://github.com/CuyZ/NotiZ/commit/ddad7d214decbcbc4accbc44e6d62d4024a8cff7) / [#120](https://github.com/CuyZ/NotiZ/issues/120)*

> 
</details>

<details>
<summary>Add right header menu in backend module</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *23 Sep 2018 / [8c9c0f6](https://github.com/CuyZ/NotiZ/commit/8c9c0f66aba089c6eca6879b3a8538ad7d3c7495) / [#119](https://github.com/CuyZ/NotiZ/issues/119)*

> 
</details>

<details>
<summary>Add backend user property to entity notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *23 Sep 2018 / [4258a99](https://github.com/CuyZ/NotiZ/commit/4258a99b9c7d8bdfb60d02b4bb201aeca992dd19) / [#118](https://github.com/CuyZ/NotiZ/issues/118)*

> 
</details>

<details>
<summary>Add header menu in backend module</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *23 Sep 2018 / [7720b6c](https://github.com/CuyZ/NotiZ/commit/7720b6c0c36c5c72a943a4ba8eeead013907d70d) / [#117](https://github.com/CuyZ/NotiZ/issues/117)*

> 
</details>

<details>
<summary>Add <code>getTitle</code> method to notification interface</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *23 Sep 2018 / [c45523a](https://github.com/CuyZ/NotiZ/commit/c45523a2ef5d7be49b012a1c396af652aa6d824b) / [#116](https://github.com/CuyZ/NotiZ/issues/116)*

> 
</details>

<details>
<summary>Select backend module for links using <code>frame</code> option</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [1d8ec75](https://github.com/CuyZ/NotiZ/commit/1d8ec758ccdab6c1278d805943e303580c7b3402) / [#114](https://github.com/CuyZ/NotiZ/issues/114)*

> 
</details>

<details>
<summary>Split backend module controller</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [3544658](https://github.com/CuyZ/NotiZ/commit/35446589d9375a7c26394b8914020143239e770d) / [#113](https://github.com/CuyZ/NotiZ/issues/113)*

> 
</details>

<details>
<summary>Check access to module for backend user</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [e3e513c](https://github.com/CuyZ/NotiZ/commit/e3e513cb9da1361292edaeb05c70958509c0cc2f) / [#112](https://github.com/CuyZ/NotiZ/issues/112)*

> 
</details>

<details>
<summary>Rename method with reserved keyword name</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [dc0f7f6](https://github.com/CuyZ/NotiZ/commit/dc0f7f61585a717248c2fd2754a2bb4652bd863a) / [#111](https://github.com/CuyZ/NotiZ/issues/111)*

> The name `for` is a reserved keyword for PHP < 7.
</details>

<details>
<summary>Change link target to avoid anchor being added to URL</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [08f33a2](https://github.com/CuyZ/NotiZ/commit/08f33a22081190a565d7a7722c11a49a2b58a7fd) / [#110](https://github.com/CuyZ/NotiZ/issues/110)*

> 
</details>

<details>
<summary>Rename "module managers" to "module handlers"</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *19 Sep 2018 / [b44614b](https://github.com/CuyZ/NotiZ/commit/b44614ba16a3cf9f332379b5d94f871a9d951b76) / [#109](https://github.com/CuyZ/NotiZ/issues/109)*

> 
</details>

<details>
<summary>Make <code>UriBuilder</code> return instance of PSR-7 <code>Uri</code></summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *13 Sep 2018 / [1df072a](https://github.com/CuyZ/NotiZ/commit/1df072acc7d8d05e4408b29a8be82097506afce4) / [#106](https://github.com/CuyZ/NotiZ/issues/106)*

> The `Uri` class allows more control than a simple string.
</details>

<details>
<summary>Add documentation for provided events</summary>

> *by [Nathan Boiron](mailto:nathan.boiron@gmail.com)* on *30 Aug 2018 / [359439c](https://github.com/CuyZ/NotiZ/commit/359439c41b0b5be16339fe5505248486f5169b29) / [#98](https://github.com/CuyZ/NotiZ/issues/98)*

> 
</details>

<details>
<summary>Move module header buttons into a partial</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [8d09171](https://github.com/CuyZ/NotiZ/commit/8d09171c5b0433fdab7049ebeca1d48a86347bf2) / [#96](https://github.com/CuyZ/NotiZ/issues/96)*

> 
</details>

<details>
<summary>Add key on SQL column <code>event</code></summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [2c7da20](https://github.com/CuyZ/NotiZ/commit/2c7da20eb379bfe7b6497be7250e295325e981aa) / [#95](https://github.com/CuyZ/NotiZ/issues/95)*

> 
</details>

<details>
<summary>Add FlexForm processor for Slack entities</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [94c9d2f](https://github.com/CuyZ/NotiZ/commit/94c9d2fe3a7155585e0e997e8b5e2e2ef6bbc3fc) / [#94](https://github.com/CuyZ/NotiZ/issues/94)*

> 
</details>

<details>
<summary>Move default event class into <code>Backend</code> namespace</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *28 Aug 2018 / [1fda232](https://github.com/CuyZ/NotiZ/commit/1fda2329c4e2208f58dfccd4ea42ce96e856e0c6) / [#93](https://github.com/CuyZ/NotiZ/issues/93)*

> 
</details>

<details>
<summary>Add Slack documentation to summary</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *08 May 2018 / [706de34](https://github.com/CuyZ/NotiZ/commit/706de34409e414dc29decb54f10bccb448b0565e) / [#86](https://github.com/CuyZ/NotiZ/issues/86)*

> 
</details>

<details>
<summary>Abstract properties from notification entities</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 May 2018 / [9deb43a](https://github.com/CuyZ/NotiZ/commit/9deb43a414972381806103a8564073de793cede7) / [#84](https://github.com/CuyZ/NotiZ/issues/84)*

> 
</details>

<details>
<summary>Update icons for email and log notification</summary>

> *by [Romain Canon](mailto:romain.hydrocanon@gmail.com)* on *02 May 2018 / [7571754](https://github.com/CuyZ/NotiZ/commit/7571754de29e86e2c5d949e1a9a70e07461558d7) / [#85](https://github.com/CuyZ/NotiZ/issues/85)*

> - Makes the TYPO3 `icon-color` feature work with TYPO3 v8.7;
> - Removes the tiny orange bell
> - Adds a default size (32 * 32)
</details>

## v0.5.0 - 26 April 2018

> ℹ️ *Click on a changelog entry to see more details.*

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

> ℹ️ *Click on a changelog entry to see more details.*

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

> ℹ️ *Click on a changelog entry to see more details.*

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

> ℹ️ *Click on a changelog entry to see more details.*

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
