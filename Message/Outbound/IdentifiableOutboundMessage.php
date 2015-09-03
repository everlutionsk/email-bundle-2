<?php

namespace Everlution\EmailBundle\Message\Outbound;

class IdentifiableOutboundMessage
{

    /** @var string */
    protected $messageId;

    /** @var OutboundMessage */
    protected $message;

    /**
     * @param string $messageId
     * @param OutboundMessage $message
     */
    public function __construct($messageId, OutboundMessage $message)
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
     * @return OutboundMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

}