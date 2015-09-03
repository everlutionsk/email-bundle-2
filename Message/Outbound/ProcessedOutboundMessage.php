<?php

namespace Everlution\EmailBundle\Message\Outbound;

use Everlution\EmailBundle\Entity\StorableOutboundMessage;

class ProcessedOutboundMessage
{

    /** @var IdentifiableOutboundMessage */
    protected $identifiableOutboundMessage;

    /** @var StorableOutboundMessage */
    protected $storableMessage;

    /**
     * @param IdentifiableOutboundMessage $identifiableOutboundMessage
     * @param StorableOutboundMessage $storableMessage
     */
    public function __construct(IdentifiableOutboundMessage $identifiableOutboundMessage, StorableOutboundMessage $storableMessage)
    {
        $this->identifiableOutboundMessage = $identifiableOutboundMessage;
        $this->storableMessage = $storableMessage;
    }

    /**
     * @return IdentifiableOutboundMessage
     */
    public function getIdentifiableOutboundMessage()
    {
        return $this->identifiableOutboundMessage;
    }

    /**
     * @return StorableOutboundMessage
     */
    public function getStorableMessage()
    {
        return $this->storableMessage;
    }

}
