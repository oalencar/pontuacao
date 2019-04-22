<?php
/**
 * Created by PhpStorm.
 * User: oscaralencar
 * Date: 2019-04-18
 * Time: 22:02
 */

namespace App\Classes;


class WhatsappMessage extends Message
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $phoneNumber;

    private $urlWAPrefix = 'https://wa.me';

    /**
     * WhatsappMessage constructor.
     * @param string $body
     * @param string $phoneNumber
     */
    public function __construct(string $body, string $phoneNumber)
    {
        $this->setBody($body);
        $this->setPhoneNumber($phoneNumber);
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
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
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return urlencode($this->body);
    }

    /**
     * @param string $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function generateSendUrl()
    {
        return $this->getUrlWAPrefix().'/'.$this->getPhoneNumber().'?text='.$this->getBody();
    }

    /**
     * @return string
     */
    public function getUrlWAPrefix(): string
    {
        return $this->urlWAPrefix;
    }


}
