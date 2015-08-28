<?php

namespace Everlution\EmailBundle\Message\Outcoming;

class IdentifiableOutcomingMessage
{

    /** @var string */
    protected $messageId;

    /** @var OutcomingMessage */
    protected $message;

    /**
     * @param string $messageId
     * @param OutcomingMessage $message
     */
    public function __construct($messageId, OutcomingMessage $message)
    {
        $this->messageId = $messageId;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @return OutcomingMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

}