<?php

namespace SendGridTransportModule;

use SendGrid;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class SendGridTransport
 * @package SendGridTransportModule
 */
class SendGridTransport implements TransportInterface
{
    /**
     * @var SendGrid
     */
    private $sendGrid;

    /**
     * @var SendGrid\Email
     */
    private $email;

    /**
     * @param SendGrid $sendGrid
     * @param SendGrid\Email $email
     */
    public function __construct(SendGrid $sendGrid, SendGrid\Email $email)
    {
        $this->sendGrid = $sendGrid;
        $this->email = $email;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function send(Message $message)
    {
        $this->email->addTo($message->getTo()->current()->getEmail(), $message->getTo()->current()->getName())
            ->setFrom($message->getFrom()->current()->getEmail(), $message->getFrom()->current()->getName())
            ->setSubject($message->getSubject())
            ->setHtml($message->getBodyText());

        $this->sendGrid->send($this->email);
        return true;
    }
}
