<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Inbound\Attachment\AttachmentSwapper;
use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Entity\Repository\StorableInboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Inbound\Message\InboundMessage;
use Everlution\EmailBundle\Inbound\Message\InboundMessageTransformer;

class MessageProcessor
{

    /** @var InboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentSwapper */
    protected $attachmentSwapper;

    /**
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentSwapper $attachmentSwapper
     */
    public function __construct(StorableMessageRepository $storableMessageRepository, AttachmentSwapper $attachmentSwapper)
    {
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentSwapper = $attachmentSwapper;
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
        $this->storeAttachments($message->getAttachments(), $storableMessage);
        $this->storeImages($message->getImages(), $storableMessage);
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

}
