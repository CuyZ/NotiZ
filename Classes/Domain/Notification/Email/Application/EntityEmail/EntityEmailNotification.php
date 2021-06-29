<?php
declare(strict_types=1);

/*
 * Copyright (C)
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

namespace CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail;

use CuyZ\Notiz\Core\Notification\Activable;
use CuyZ\Notiz\Core\Notification\Creatable;
use CuyZ\Notiz\Core\Notification\Viewable;
use CuyZ\Notiz\Core\Notification\Editable;
use CuyZ\Notiz\Core\Notification\CustomSettingsNotification;
use CuyZ\Notiz\Core\Property\PropertyEntry;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Processor\EntityEmailNotificationProcessor;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Settings\EntityEmailSettings;
use CuyZ\Notiz\Domain\Notification\Email\EmailNotification;
use CuyZ\Notiz\Domain\Notification\EntityNotification;
use CuyZ\Notiz\Domain\Property\Email;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EntityEmailNotification extends EntityNotification implements
    EmailNotification,
    CustomSettingsNotification,
    Creatable,
    Editable,
    Viewable,
    Activable
{
    /**
     * @var string
     */
    protected $layout;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var bool
     */
    protected $senderCustom;

    /**
     * @var string
     */
    protected $sendTo;

    /**
     * @var string
     */
    protected $sendToProvided;

    /**
     * @var string
     */
    protected $sendCc;

    /**
     * @var string
     */
    protected $sendCcProvided;

    /**
     * @var string
     */
    protected $sendBcc;

    /**
     * @var string
     */
    protected $sendBccProvided;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $bodySlots = [];

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return bool
     */
    public function isSenderCustom(): bool
    {
        return $this->senderCustom;
    }

    /**
     * @param bool $senderCustom
     */
    public function setSenderCustom(bool $senderCustom)
    {
        $this->senderCustom = $senderCustom;
    }

    /**
     * @return string
     */
    public function getSendTo(): string
    {
        return $this->sendTo;
    }

    /**
     * @param string $sendTo
     */
    public function setSendTo(string $sendTo)
    {
        $this->sendTo = $sendTo;
    }

    /**
     * @return string
     */
    public function getSendToProvided(): string
    {
        return $this->sendToProvided;
    }

    /**
     * @return Email[]
     */
    public function getSelectedSendToProvided(): array
    {
        return $this->getSelectedProvidedRecipients($this->sendToProvided);
    }

    /**
     * @param string $sendToProvided
     */
    public function setSendToProvided(string $sendToProvided)
    {
        $this->sendToProvided = $sendToProvided;
    }

    /**
     * @return string
     */
    public function getSendCc(): string
    {
        return $this->sendCc;
    }

    /**
     * @param string $sendCc
     */
    public function setSendCc(string $sendCc)
    {
        $this->sendCc = $sendCc;
    }

    /**
     * @return string
     */
    public function getSendCcProvided(): string
    {
        return $this->sendCcProvided;
    }

    /**
     * @return Email[]
     */
    public function getSelectedSendCcProvided(): array
    {
        return $this->getSelectedProvidedRecipients($this->sendCcProvided);
    }

    /**
     * @param string $sendCcProvided
     */
    public function setSendCcProvided(string $sendCcProvided)
    {
        $this->sendCcProvided = $sendCcProvided;
    }

    /**
     * @return string
     */
    public function getSendBcc(): string
    {
        return $this->sendBcc;
    }

    /**
     * @param string $sendBcc
     */
    public function setSendBcc(string $sendBcc)
    {
        $this->sendBcc = $sendBcc;
    }

    /**
     * @return string
     */
    public function getSendBccProvided(): string
    {
        return $this->sendBccProvided;
    }

    /**
     * @return Email[]
     */
    public function getSelectedSendBccProvided(): array
    {
        return $this->getSelectedProvidedRecipients($this->sendBccProvided);
    }

    /**
     * @param string $sendBccProvided
     */
    public function setSendBccProvided(string $sendBccProvided)
    {
        $this->sendBccProvided = $sendBccProvided;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getBodySlots(): array
    {
        if (empty($this->bodySlots)) {
            $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
            $this->bodySlots = $flexFormService->convertFlexFormContentToArray($this->body);
        }

        return $this->bodySlots;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public static function getProcessorClassName(): string
    {
        return EntityEmailNotificationProcessor::class;
    }

    /**
     * @return string
     */
    public static function getDefinitionIdentifier(): string
    {
        return 'entityEmail';
    }

    /**
     * @return string
     */
    public static function getSettingsClassName(): string
    {
        return EntityEmailSettings::class;
    }

    /**
     * @param string $providedRecipients
     * @return Email[]
     */
    protected function getSelectedProvidedRecipients(string $providedRecipients): array
    {
        if (!$this->hasEventDefinition()) {
            return [];
        }

        $providedRecipients = GeneralUtility::trimExplode(',', $providedRecipients);

        return array_filter(
            $this->getEmailProperties(),
            function (Email $email) use ($providedRecipients) {
                return in_array($email->getName(), $providedRecipients);
            }
        );
    }

    /**
     * @return PropertyEntry[]|Email[]
     */
    protected function getEmailProperties()
    {
        return $this->getEventDefinition()
            ->getPropertyDefinition(Email::class, $this)
            ->getEntries();
    }
}
