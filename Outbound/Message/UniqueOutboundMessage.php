<?php

namespace Everlution\EmailBundle\Outbound\Message;

use Everlution\EmailBundle\Message\IdentifiableMessage;

class UniqueOutboundMessage implements IdentifiableMessage
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