<?php

namespace Everlution\EmailBundle\Outbound\MessageEvent;

use InvalidArgumentException;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessageInfo as MessageInfoRepository;
use Everlution\EmailBundle\Entity\StorableOutboundMessageInfo;

class MessageEventProcessor
{

    /** @var MessageInfoRepository */
    protected $messageInfoRepository;

    /**
     * @param MessageInfoRepository $messageInfoRepository
     */
    public function __construct(MessageInfoRepository $messageInfoRepository)
    {
        $this->messageInfoRepository = $messageInfoRepository;
    }

    /**
     * @param MessageEvent $messageEvent
     * @throws InvalidArgumentException
     */
    public function changeMessageState(MessageEvent $messageEvent)
    {
        $messageInfo = $this->findMessageInfoEntity($messageEvent);

        if ($messageInfo === null) {
            throw new InvalidArgumentException('Cannot change MessageState. Message not found!');
        }

        $messageInfo->setStatus($messageEvent->getStatus());
        $messageInfo->setRejectReason($messageEvent->getRejectReason());

        $this->messageInfoRepository->save($messageInfo);
    }

    /**
     * @param MessageEvent $messageEvent
     * @return StorableOutboundMessageInfo|null
     */
    private function findMessageInfoEntity(MessageEvent $messageEvent)
    {
        $mailSystemName = $messageEvent->getMailSystemName();
        $mailSystemMessageId = $messageEvent->getMailSystemMessageId();

        return $this->messageInfoRepository->findOneByMailSystemMessageId($mailSystemMessageId, $mailSystemName);
    }

}
