<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Everlution\EmailBundle\Entity\StorableOutboundMessageStatus as Entity;

class StorableOutboundMessageStatus extends BaseRepository
{

    /**
     * @param string $mailSystemMessageId
     * @param string $mailSystemName
     * @return Entity|null
     */
    public function findOneByMailSystemMessageId($mailSystemMessageId, $mailSystemName)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->join('i.storableOutboundMessage', 'm', 'WITH', 'm.mailSystem = :mailSystemName');
        $qb->where('i.mailSystemMessageId = :mailSystemMessageId');

        $qb->setParameters([
            'mailSystemMessageId' => $mailSystemMessageId,
            'mailSystemName' => $mailSystemName
        ]);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @return array
     */
    public function findAllRejected()
    {
        return $this
            ->createQueryBuilder('i')
            ->where('i.rejectReason IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}
