<?php

namespace Everlution\EmailBundle\Entity\Repository;

use Everlution\EmailBundle\Entity\StorableOutboundMessageStatus as Entity;

class StorableOutboundMessageStatus extends BaseRepository
{
    protected const MAX_RESEND_ATTEMPTS = 3;

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
            ->join('i.storableOutboundMessage', 'm')
            ->where('i.rejectReason IS NOT NULL')
            ->andWhere('m.resendAttempts < :resendAttempts')
            ->setParameter('resendAttempts', self::MAX_RESEND_ATTEMPTS)
            ->getQuery()
            ->getResult();
    }
}
