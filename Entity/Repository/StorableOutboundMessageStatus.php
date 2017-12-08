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
     * @param int $limit
     * @param int $maxResendAttempts
     *
     * @return array
     */
    public function findAllRejected(int $limit, int $maxResendAttempts)
    {
        return $this
            ->createQueryBuilder('i')
            ->join('i.storableOutboundMessage', 'm')
            ->where('i.rejectReason IS NOT NULL')
            ->andWhere('m.resendAttempts < :resendAttempts')
            ->setParameter('resendAttempts', $maxResendAttempts)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
