<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Everlution\EmailBundle\Entity\StorableOutboundMessage as Entity;

class StorableOutboundMessage extends BaseRepository
{

    /**
     * @param string $messageId
     * @return Entity|null
     */
    public function findMessage($messageId)
    {
        return $this->findOneBy(['messageId' => $messageId]);
    }

    /**
     * @param string $messageId
     * @return Entity[]
     */
    public function findResponsesTo($messageId)
    {
        return $this->findBy(['inReplyTo' => $messageId]);
    }

}
