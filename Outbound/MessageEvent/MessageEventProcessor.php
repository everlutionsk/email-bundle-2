<?php

namespace Everlution\EmailBundle\Outbound\MessageEvent;

use InvalidArgumentException;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessageStatus as MessageStatusRepository;
use Everlution\EmailBundle\Entity\StorableOutboundMessageStatus;

class MessageEventProcessor
{

    /** @var MessageStatusRepository */
    protected $messageStatusRepository;

    /**
     * @param MessageStatusRepository $messageStatusRepository
     */
    public function __construct(MessageStatusRepository $messageStatusRepository)
    {
        $this->messageStatusRepository = $messageStatusRepository;
    }

    /**
     * @param MessageEvent $messageEvent
     * @throws InvalidArgumentException
     */
    public function changeMessageState(MessageEvent $messageEvent)
    {
        $storableMessageStatus = $this->findStorableMessageStatus($messageEvent);

        if ($storableMessageStatus === null) {
            throw new InvalidArgumentException('Cannot change MessageStatus. Message not found!');
        }

        $storableMessageStatus->setStatus($messageEvent->getStatus());
        $storableMessageStatus->setRejectReason($messageEvent->getRejectReason());

        $this->messageStatusRepository->save($storableMessageStatus);
    }

    /**
     * @param MessageEvent $messageEvent
     * @return StorableOutboundMessageStatus|null
     */
    protected function findStorableMessageStatus(MessageEvent $messageEvent)
    {
        $mailSystemName = $messageEvent->getMailSystemName();
        $mailSystemMessageId = $messageEvent->getMailSystemMessageId();

        return $this->messageStatusRepository->findOneByMailSystemMessageId($mailSystemMessageId, $mailSystemName);
    }

}
