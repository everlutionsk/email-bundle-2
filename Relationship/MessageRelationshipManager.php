<?php

namespace Everlution\EmailBundle\Relationship;

use Everlution\EmailBundle\Entity\Repository\StorableInboundMessage as StorableInboundMessageRepository;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessage as StorableOutboundMessageRepository;
use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Entity\StorableOutboundMessage;
use Everlution\EmailBundle\Message\IdentifiableMessage;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;

class MessageRelationshipManager
{

    const SUBJECT_PREFIX = 'Re: ';

    /** @var StorableInboundMessageRepository */
    protected $inboundMessageRepository;

    /** @var StorableOutboundMessageRepository */
    protected $outboundMessageRepository;

    /**
     * @param StorableInboundMessageRepository $inboundMessageRepository
     * @param StorableOutboundMessageRepository $outboundMessageRepository
     */
    public function __construct(StorableInboundMessageRepository $inboundMessageRepository, StorableOutboundMessageRepository $outboundMessageRepository)
    {
        $this->inboundMessageRepository = $inboundMessageRepository;
        $this->outboundMessageRepository = $outboundMessageRepository;
    }

    /**
     * @param OutboundMessage $message
     * @param ReplyableMessage $parentMessage
     */
    public function modifyToReplyMessage(OutboundMessage $message, ReplyableMessage $parentMessage)
    {
        $references = $parentMessage->getReferences() . ' ' . $parentMessage->getMessageId();

        $message->setReferences($references);
        $message->setInReplyTo($parentMessage->getMessageId());
        $message->setSubject(static::SUBJECT_PREFIX . $parentMessage->getSubject());
    }

    /**
     * @param IdentifiableMessage $message
     * @return StorableInboundMessage[]
     */
    public function findStoredInboundResponsesTo(IdentifiableMessage $message)
    {
        return $this->inboundMessageRepository->findResponsesTo($message->getMessageId());
    }

    /**
     * @param IdentifiableMessage $message
     * @return StorableOutboundMessage[]
     */
    public function findStoredOutboundResponsesTo(IdentifiableMessage $message)
    {
        return $this->outboundMessageRepository->findResponsesTo($message->getMessageId());
    }

}
