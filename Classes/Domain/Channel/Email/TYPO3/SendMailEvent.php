<?php


namespace CuyZ\Notiz\Domain\Channel\Email\TYPO3;


use CuyZ\Notiz\Core\Channel\Payload;
use TYPO3\CMS\Core\Mail\MailMessage;

class SendMailEvent
{

    protected MailMessage $message;
    protected Payload $payload;

    public function __construct(MailMessage $message, Payload $payload)
    {
        $this->message = $message;
        $this->payload = $payload;
    }

    /**
     * @return MailMessage
     */
    public function getMessage(): MailMessage
    {
        return $this->message;
    }

    /**
     * @return Payload
     */
    public function getPayload(): Payload
    {
        return $this->payload;
    }

}
