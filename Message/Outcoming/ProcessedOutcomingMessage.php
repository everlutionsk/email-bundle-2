<?php

namespace Everlution\EmailBundle\Message\Outcoming;

use Everlution\EmailBundle\Entity\StorableOutcomingMessage;

class ProcessedOutcomingMessage
{

    /** @var IdentifiableOutcomingMessage */
    protected $identifiableOutcomingMessage;

    /** @var StorableOutcomingMessage */
    protected $storableMessage;

    /**
     * @param IdentifiableOutcomingMessage $identifiableOutcomingMessage
     * @param StorableOutcomingMessage $storableMessage
     */
    public function __construct(IdentifiableOutcomingMessage $identifiableOutcomingMessage, StorableOutcomingMessage $storableMessage)
    {
        $this->identifiableOutcomingMessage = $identifiableOutcomingMessage;
        $this->storableMessage = $storableMessage;
    }

    /**
     * @return IdentifiableOutcomingMessage
     */
    public function getIdentifiableOutcomingMessage()
    {
        return $this->identifiableOutcomingMessage;
    }

    /**
     * @return StorableOutcomingMessage
     */
    public function getStorableMessage()
    {
        return $this->storableMessage;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->storableMessage->getStatus();
    }

}
