.. include:: ../../Includes.txt

.. _notification-email-objectCustomization:

Email object customization
--------------------------

Advanced modification can be done on the email, using a TYPO3 signal:

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    $dispatcher->connect(
        \CuyZ\Notiz\Domain\Channel\Email\TYPO3\EmailChannel::class,
        \CuyZ\Notiz\Domain\Channel\Email\TYPO3\EmailChannel::EMAIL_SIGNAL,
        \Vendor\MyExtension\Service\Mail\MailTransformer::class,
        'transform'
    );

The object can then be modified as needed:

.. code-block:: php
    :caption: ``my_extension/Classes/Service/Mail/MailTransformer.php``

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
