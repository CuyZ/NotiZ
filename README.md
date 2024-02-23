> [!IMPORTANT]  
> Due to lack of time and motivation, and mostly because I stopped working with TYPO3 on a daily basis, **this project is not maintained anymore**. If anyone wants to maintain it, please feel free to contact me; [creating an issue](https://github.com/CuyZ/NotiZ/issues/new) seems to be the best way to discuss about it.

---

# ![NotiZ](ext_icon.svg) NotiZ • Powerful notification dispatcher

> **“Handle any type of notification in TYPO3 with ease: emails, SMS, Slack and 
more. Listen to your own events or provided ones (scheduler task finishing, 
extension installed, etc…).”**

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Scrutinizer Code Quality][ico-scrutinizer]][link-scrutinizer]
[![StyleCI check][ico-styleci]][link-styleci]
[![Maintainability][ico-codeclimate]][link-codeclimate]

---

NotiZ is a ![TYPO3][typo3][TYPO3 extension][link-ter] allowing to easily manage 
notifications in a TYPO3 instance.

Notifications listen to events fired within the application and can be
dispatched to several channels: emails, SMS, Slack messages…

To ease editors lives, everything can be managed directly in the TYPO3 backend.

![Example][gif-example]

## Install

See [Installation chapter][link-doc-installation] from the documentation.

## Documentation

Find the documentation on [docs.typo3.org][link-doc].

> ![Slack][slack] Join the discussion on Slack in channel 
 [**#ext-notiz**][link-slack]! – You don't have access to TYPO3 Slack? Get your 
Slack invitation [by clicking here][link-slack-invite]!

## Change log

See [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

See [LICENSE](LICENSE.MD) for more information.

[typo3]: Documentation/Images/Icon/icon-typo3.svg
[slack]: Documentation/Images/Icon/icon-slack.svg

[ico-version]: https://img.shields.io/packagist/v/cuyz/notiz.svg
[ico-downloads]: https://img.shields.io/packagist/dt/cuyz/notiz.svg
[ico-license]: https://img.shields.io/badge/license-GPL3-brightgreen.svg
[ico-scrutinizer]: https://scrutinizer-ci.com/g/CuyZ/NotiZ/badges/quality-score.png?b=master
[ico-styleci]: https://styleci.io/repos/113041297/shield?style=flat&branch=master
[ico-codeclimate]: https://api.codeclimate.com/v1/badges/bee13dc7e268cb6ac7b9/maintainability
[gif-example]: Documentation/Images/notiz-demo.gif

[link-ter]: https://extensions.typo3.org/extension/notiz/
[link-doc]: https://docs.typo3.org/typo3cms/extensions/notiz/
[link-doc-installation]: https://docs.typo3.org/typo3cms/extensions/notiz/02-Installation/Index.html
[link-slack]: https://typo3.slack.com/messages/ext-notiz
[link-slack-invite]: https://forger.typo3.org/slack
[link-packagist]: https://packagist.org/packages/cuyz/notiz
[link-downloads]: https://packagist.org/packages/cuyz/notiz
[link-scrutinizer]: https://scrutinizer-ci.com/g/CuyZ/NotiZ/?branch=master
[link-styleci]: https://styleci.io/repos/113041297
[link-codeclimate]: https://codeclimate.com/github/CuyZ/NotiZ/maintainability
