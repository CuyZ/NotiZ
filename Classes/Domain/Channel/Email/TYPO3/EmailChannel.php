<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\Domain\Channel\Email\TYPO3;

use CuyZ\Notiz\Core\Channel\AbstractChannel;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Service\EntityEmailAddressMapper;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Service\EntityEmailTemplateBuilder;
use CuyZ\Notiz\Domain\Notification\Email\EmailNotification;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Channel using the default `MailMessage` provided by the TYPO3 core.
 *
 * If you need to do advanced modification on your mail, you can use a PHP
 * signal. Register the slot in your `ext_localconf.php` file :
 *
 * ```
 * // my_extension/ext_localconf.php
 *
 * $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
 *     \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
 * );
 *
 * $dispatcher->connect(
 *     \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
 *     \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::COMPONENTS_SIGNAL,
 *     \Vendor\MyExtension\Service\Mail\MailTransformer::class,
 *     'registerDefinitionComponents'
 * );
 * ```
 *
 * Then modify your mail object as you need:
 *
 * ```
 * // my_extension/Classes/Service/Mail/MailTransformer.php
 *
 * namespace Vendor\MyExtension\Service\Mail;
 *
 * use CuyZ\Notiz\Core\Channel\Payload;
 * use TYPO3\CMS\Core\Mail\MailMessage;
 * use TYPO3\CMS\Core\SingletonInterface;
 * use TYPO3\CMS\Core\Utility\GeneralUtility;
 *
 * class MailTransformer implements SingletonInterface
 * {
 *     public function transform(MailMessage $mailMessage, Payload $payload)
 *     {
 *         $applicationContext = GeneralUtility::getApplicationContext();
 *
 *         // We don't change anything in production.
 *         if ($applicationContext->isProduction()) {
 *             return;
 *         }
 *
 *         // Add a prefix to the mail subject, containing the application context.
 *         $subject = "[$applicationContext][NotiZ] " . $mailMessage->getSubject();
 *         $mailMessage->setSubject($subject);
 *
 *         // When not in production, we want the mail to be sent only to us.
 *         $mailMessage->setTo('webmaster@acme.com');
 *         $mailMessage->setCc([]);
 *         $mailMessage->setBcc([]);
 *     }
 * }
 * ```
 */
class EmailChannel extends AbstractChannel
{
    const EMAIL_SIGNAL = 'sendEmail';

    /**
     * @var array
     */
    protected static $supportedNotifications = [
        EmailNotification::class,
    ];

    /**
     * @var EntityEmailTemplateBuilder
     */
    protected $templateBuilder;

    /**
     * @var EntityEmailAddressMapper
     */
    protected $addressMapper;

    /**
     * @var Dispatcher
     */
    protected $slotDispatcher;

    /**
     * Setting up services used by this channel.
     */
    protected function initialize()
    {
        $this->templateBuilder = $this->objectManager->get(EntityEmailTemplateBuilder::class, $this->payload);
        $this->addressMapper = $this->objectManager->get(EntityEmailAddressMapper::class, $this->payload);
    }

    /**
     * Sends the mail with processed recipients and subject/body.
     */
    protected function process()
    {
        /** @var MailMessage $mailMessage */
        $mailMessage = GeneralUtility::makeInstance(MailMessage::class);

        $mailMessage
            ->setSubject($this->templateBuilder->getSubject())
            ->setBody($this->templateBuilder->getBody())
            ->setFrom($this->addressMapper->getSender())
            ->setTo($this->addressMapper->getSendTo())
            ->setCc($this->addressMapper->getSendCc())
            ->setBcc($this->addressMapper->getSendBcc())
            ->setContentType('text/html');

        $this->dispatchEmailSignal($mailMessage);

        $mailMessage->send();
    }

    /**
     * @param MailMessage $mailMessage
     */
    protected function dispatchEmailSignal(MailMessage $mailMessage)
    {
        $this->slotDispatcher->dispatch(
            self::class,
            self::EMAIL_SIGNAL,
            [
                $mailMessage,
                $this->payload,
            ]
        );
    }

    /**
     * @param Dispatcher $slotDispatcher
     */
    public function injectSlotDispatcher(Dispatcher $slotDispatcher)
    {
        $this->slotDispatcher = $slotDispatcher;
    }
}
