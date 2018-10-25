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

use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;
use CuyZ\Notiz\Core\Notification\Settings\NotificationSettings;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\EntityEmailNotification;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Settings\EntityEmailSettings;
use CuyZ\Notiz\Domain\Notification\Email\Application\EntityEmail\Settings\GlobalRecipients\Recipient;
use CuyZ\Notiz\Domain\Property\Email;
use CuyZ\Notiz\Service\LocalizationService;

class EntityEmailTcaService extends NotificationTcaService
{
    /**
     * Loads all recipients provided by the selected event and stores them as an
     * array to be used in the TCA.
     *
     * @param array $parameters
     */
    public function getRecipientsList(array &$parameters)
    {
        if ($this->definitionHasErrors()) {
            return;
        }

        $row = $parameters['row'];
        $eventDefinition = $this->getSelectedEvent($row);
        $notification = $this->getNotification($row);

        $eventRecipients = array_map(
            function (Email $recipient) {
                return [
                    'label' => $recipient->getLabel(),
                    'value' => $recipient->getName(),
                ];
            },
            $eventDefinition->getPropertyDefinition(Email::class, $notification)->getEntries()
        );

        $globalRecipients = array_map(
            function (Recipient $recipient) {
                return [
                    'label' => $recipient->getName(),
                    'value' => $recipient->getIdentifier(),
                ];
            },
            $this->getNotificationSettings()->getGlobalRecipients()->getRecipients()
        );

        if (!empty($eventRecipients)) {
            $this->appendOptionGroup($eventRecipients, LocalizationService::localize('Notification/Email/Entity:field.recipients.event_recipients'));
        }

        if (!empty($globalRecipients)) {
            $this->appendOptionGroup($globalRecipients, LocalizationService::localize('Notification/Email/Entity:field.recipients.global_recipients'));
        }

        $recipients = array_merge_recursive($eventRecipients, $globalRecipients);

        foreach ($recipients as $recipient) {
            $parameters['items'][] = [
                $recipient['label'],
                $recipient['value'],
            ];
        }
    }

    /**
     * List all available layouts and stores them as an array
     * to be used in the TCA.
     *
     * @param array $parameters
     */
    public function getLayoutList(array &$parameters)
    {
        if ($this->definitionHasErrors()) {
            return;
        }

        $layouts = $this->getNotificationSettings()->getView()->getLayouts();

        foreach ($layouts as $key => $layout) {
            $label = $layout->hasLabel()
                ? $layout->getLabel()
                : LocalizationService::localize('Notification/Email/Entity:field.layout.undefined_label', [$key]);

            $parameters['items'][] = [
                $label,
                $layout->getIdentifier(),
            ];
        }
    }

    /**
     * @return string
     */
    public function getDefaultSender()
    {
        if ($this->definitionHasErrors()) {
            return '';
        }

        return $this->getNotificationSettings()->getDefaultSender();
    }

    /**
     * This methods returns true if the current selected event has one provided
     * email address. This is used as a displayCond in the TCA.
     *
     * @param array $parameters
     * @return bool
     */
    public function shouldShowProvidedRecipientsSelect(array $parameters)
    {
        if ($this->definitionHasErrors()) {
            return false;
        }

        $row = $parameters['record'];
        $eventDefinition = $this->getSelectedEvent($row);
        $notification = $this->getNotification($row);

        /** @var Email[] $recipients */
        $recipients = $eventDefinition->getPropertyDefinition(Email::class, $notification)->getEntries();

        $globalRecipients = $this->getNotificationSettings()
            ->getGlobalRecipients()
            ->getRecipients();

        return count($recipients) > 0 || count($globalRecipients) > 0;
    }

    /**
     * @return EntityEmailSettings|NotificationSettings
     */
    protected function getNotificationSettings()
    {
        return $this->getNotificationDefinition()->getSettings();
    }

    /**
     * @return string
     */
    protected function getDefinitionIdentifier()
    {
        return EntityEmailNotification::getDefinitionIdentifier();
    }
}
