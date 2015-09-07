<?php

namespace Everlution\EmailBundle\Outbound\Message;

use Everlution\EmailBundle\Entity\StorableOutboundMessage;

class ProcessedOutboundMessage
{

    /** @var UniqueOutboundMessage */
    protected $uniqueOutboundMessage;

    /** @var StorableOutboundMessage */
    protected $storableMessage;

    /**
     * @param UniqueOutboundMessage $uniqueOutboundMessage
     * @param StorableOutboundMessage $storableMessage
     */
    public function __construct(UniqueOutboundMessage $uniqueOutboundMessage, StorableOutboundMessage $storableMessage)
    {
        $this->uniqueOutboundMessage = $uniqueOutboundMessage;
        $this->storableMessage = $storableMessage;
    }

    /**
     * @return UniqueOutboundMessage
     */
    public function getUniqueOutboundMessage()
    {
        return $this->uniqueOutboundMessage;
    }

    /**
     * @return StorableOutboundMessage
     */
    public function getStorableMessage()
    {
        return $this->storableMessage;
    }

}
