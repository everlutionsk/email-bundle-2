<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Everlution\EmailBundle\Entity\StorableIncomingMessage as Entity;

class StorableIncomingMessage extends EntityRepository
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
     * @param Entity $message
     */
    public function save(Entity $message)
    {
        $this->_em->persist($message);
        $this->_em->flush($message);
    }

}
