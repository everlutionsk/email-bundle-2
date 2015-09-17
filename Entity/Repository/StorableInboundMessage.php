<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Everlution\EmailBundle\Entity\StorableInboundMessage as Entity;

class StorableInboundMessage extends BaseRepository
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
