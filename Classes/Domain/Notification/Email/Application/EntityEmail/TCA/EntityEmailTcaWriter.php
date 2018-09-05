<?php

/*
 * Copyright (C) 2018
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

namespace CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\TCA;

use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;

class EntityEmailTcaWriter extends EntityTcaWriter
{
    const EMAIL_LLL = 'LLL:EXT:notiz/Resources/Private/Language/Notification/Email/Entity.xlf';

    /**
     * @var EntityEmailTcaService
     */
    protected $service;

    /**
     * @return string
     */
    protected function getNotificationTcaServiceClass()
    {
        return EntityEmailTcaService::class;
    }

    /**
     * @return string
     */
    protected function getChannelLabel()
    {
        return self::EMAIL_LLL . ':field.mailer';
    }

    /**
     * @inheritdoc
     */
    protected function buildTcaArray()
    {
        return [
            'ctrl' => $this->getCtrl(),

            'palettes' => [
                'mail' => [
                    'showitem' => 'subject,markers,--linebreak--,body',
                    'canNotCollapse' => true,
                ],
                'send_to' => [
                    'showitem' => 'send_to,--linebreak--,send_to_provided',
                    'canNotCollapse' => true,
                ],
                'send_cc' => [
                    'showitem' => 'send_cc,--linebreak--,send_cc_provided',
                    'canNotCollapse' => true,
                ],
                'send_bcc' => [
                    'showitem' => 'send_bcc,--linebreak--,send_bcc_provided',
                    'canNotCollapse' => true,
                ],
            ],

            'types' => [
                '0' => [
                    'showitem' => '
                        error_message,
                        title, description, sys_language_uid, hidden,
                        --div--;' . self::LLL_TABS . ':tab.event,
                            event, event_configuration_flex,
                        --div--;' . self::LLL_TABS . ':tab.channel,
                            channel,
                        --div--;' . self::EMAIL_LLL . ':tab.mail_configuration,
                            layout,
                            --palette--;' . self::EMAIL_LLL . ':palette.mail;mail,
                        --div--;' . self::EMAIL_LLL . ':tab.mail_recipients,
                            --palette--;' . self::EMAIL_LLL . ':palette.mail_recipients_to;send_to,
                            --palette--;' . self::EMAIL_LLL . ':palette.mail_recipients_cc;send_cc,
                            --palette--;' . self::EMAIL_LLL . ':palette.mail_recipients_bcc;send_bcc,
                        --div--;' . self::EMAIL_LLL . ':tab.mail_sender,
                            sender_custom,--linebreak--,sender,sender_default,
                        ',
                ],
            ],

            'columns' => [

                // Mail configuration

                'layout' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.layout',
                    'l10n_mode' => 'exclude',
                    'l10n_display' => 'defaultAsReadonly',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getLayoutList',
                        'size' => 1,
                        'maxitems' => 1,
                        'eval' => 'required',
                    ],
                ],

                // Mail content

                'subject' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.subject',
                    'config' => [
                        'type' => 'input',
                        'size' => 40,
                        'eval' => 'trim,required',
                    ],
                ],

                'body' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.body',
                    'displayCond' => $this->service->getMailBodyDisplayCond(),
                    'config' => [
                        'type' => 'flex',
                        'ds_pointerField' => 'event',
                        'ds' => $this->service->getMailBodyFlexFormList(),
                        'behaviour' => [
                            'allowLanguageSynchronization' => true,
                        ],
                    ],
                ],

                // Sender

                'sender_custom' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.sender_custom',
                    'config' => [
                        'type' => 'check',
                        'default' => 0,
                    ],
                ],

                'sender_default' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.sender_default',
                    'displayCond' => 'FIELD:sender_custom:=:0',
                    'config' => [
                        'type' => 'user',
                        'userFunc' => $this->getNotificationTcaServiceClass() . '->getDefaultSender',
                    ],
                ],

                'sender' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.sender',
                    'displayCond' => 'FIELD:sender_custom:=:1',
                    'l10n_mode' => 'exclude',
                    'l10n_display' => 'defaultAsReadonly',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'email,required',
                        'default' => '',
                        'placeholder' => 'no-reply@example.com',
                    ],
                ],

                // Recipients

                'send_to' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_to',
                    'config' => [
                        'type' => 'input',
                        'size' => 512,
                        'eval' => 'trim',
                        'placeholder' => 'john@example.com, jane@example.com',
                    ],
                ],

                'send_to_provided' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_to_provided',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->shouldShowProvidedRecipientsSelect',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getRecipientsList',
                        'renderType' => 'selectMultipleSideBySide',
                        'size' => 5,
                        'maxitems' => 128,
                    ],
                ],

                'send_cc' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_cc',
                    'config' => [
                        'type' => 'input',
                        'size' => 512,
                        'eval' => 'trim',
                        'placeholder' => 'john@example.com, jane@example.com',
                    ],
                ],

                'send_cc_provided' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_cc_provided',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->shouldShowProvidedRecipientsSelect',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getRecipientsList',
                        'renderType' => 'selectMultipleSideBySide',
                        'size' => 5,
                        'maxitems' => 128,
                    ],
                ],

                'send_bcc' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_bcc',
                    'config' => [
                        'type' => 'input',
                        'size' => 512,
                        'eval' => 'trim',
                        'placeholder' => 'john@example.com, jane@example.com',
                    ],
                ],

                'send_bcc_provided' => [
                    'exclude' => 1,
                    'label' => self::EMAIL_LLL . ':field.send_bcc_provided',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->shouldShowProvidedRecipientsSelect',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getRecipientsList',
                        'renderType' => 'selectMultipleSideBySide',
                        'size' => 5,
                        'maxitems' => 128,
                    ],
                ],

            ],
        ];
    }

    /**
     * @return array
     */
    protected function getCtrl()
    {
        $ctrl = $this->getDefaultCtrl();

        $ctrl['requestUpdate'] .= ',sender_custom';
        $ctrl['searchFields'] .= ',sender,sender_custom,send_to,send_to_provided,send_cc,send_cc_provided,send_bcc,send_bcc_provided,subject,body';

        return $ctrl;
    }

    /**
     * @return string
     */
    protected function getEntityTitle()
    {
        return self::EMAIL_LLL . ':title';
    }
}
