<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Inbound\Message\InboundMessage;
use Symfony\Component\EventDispatcher\Event;

class InboundEvent extends Event
{

    /** @var InboundMessage */
    protected $message;

    /** @var StorableInboundMessage */
    protected $storableMessage;

    /**
     * InboundEvent constructor.
     * @param InboundMessage $message
     * @param StorableInboundMessage $storableMessage
     */
    public function __construct(InboundMessage $message, StorableInboundMessage $storableMessage)
    {
        $this->message = $message;
        $this->storableMessage = $storableMessage;
    }

    /**
     * @return InboundMessage
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return StorableInboundMessage
     */
    public function getStorableMessage()
    {
        return $this->storableMessage;
    }

}
