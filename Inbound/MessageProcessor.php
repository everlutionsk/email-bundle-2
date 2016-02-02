<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Inbound\Attachment\AttachmentSwapper;
use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Entity\Repository\StorableInboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Inbound\Message\InboundMessage;
use Everlution\EmailBundle\Inbound\Message\InboundMessageTransformer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MessageProcessor
{

    /** @var InboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentSwapper */
    protected $attachmentSwapper;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentSwapper $attachmentSwapper
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        StorableMessageRepository $storableMessageRepository,
        AttachmentSwapper $attachmentSwapper = null,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentSwapper = $attachmentSwapper;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param InboundMessageTransformer $transformer
     */
    public function addMessageTransformer(InboundMessageTransformer $transformer)
    {
        $this->messageTransformers[] = $transformer;
    }

    /**
     * @param InboundMessage $message
     */
    public function storeInboundMessage(InboundMessage $message)
    {
        $this->transformMessage($message);

        $storableMessage = new StorableInboundMessage($message);

        $this->storeStorableMessage($storableMessage);

        if ($this->attachmentSwapper) {
            $this->storeAttachments($message->getAttachments(), $storableMessage);
            $this->storeImages($message->getImages(), $storableMessage);
        }

        $this->dispatchInboundEvent($message, $storableMessage);
    }

    /**
     * @param InboundMessage $message
     */
    protected function transformMessage(InboundMessage $message)
    {
        foreach ($this->messageTransformers as $transformer) {
            $transformer->transform($message);
        }
    }

    /**
     * @param StorableInboundMessage $storableMessage
     */
    protected function storeStorableMessage(StorableInboundMessage $storableMessage)
    {
        $this->storableMessageRepository->save($storableMessage);
    }

    /**
     * @param Attachment[] $attachments
     * @param StorableInboundMessage $storableMessage
     */
    protected function storeAttachments(array $attachments, StorableInboundMessage $storableMessage)
    {
        $this->attachmentSwapper->saveAttachments($attachments, $storableMessage);
    }

    /**
     * @param Attachment[] $images
     * @param StorableInboundMessage $storableMessage
     */
    protected function storeImages(array $images, StorableInboundMessage $storableMessage)
    {
        $this->attachmentSwapper->saveImages($images, $storableMessage);
    }

    /**
     * @param InboundMessage $message
     * @param StorableInboundMessage $storableMessage
     */
    protected function dispatchInboundEvent(InboundMessage $message, StorableInboundMessage $storableMessage)
    {
        $event = new InboundEvent($message, $storableMessage);
        $this->eventDispatcher->dispatch('everlution.email.inbound', $event);
    }

}
