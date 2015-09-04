<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Attachment\AttachmentManager;
use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Entity\Repository\StorableInboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Message\Inbound\InboundMessage;
use Everlution\EmailBundle\Transformer\InboundMessageTransformer;

class MessageProcessor
{

    /** @var InboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentManager */
    protected $attachmentManager;

    /**
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentManager $attachmentManager
     */
    public function __construct(StorableMessageRepository $storableMessageRepository, AttachmentManager $attachmentManager)
    {
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentManager = $attachmentManager;
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
        $this->attachmentManager->saveAttachments($attachments, $storableMessage);
    }

    /**
     * @param Attachment[] $images
     * @param StorableInboundMessage $storableMessage
     */
    protected function storeImages(array $images, StorableInboundMessage $storableMessage)
    {
        $this->attachmentManager->saveImages($images, $storableMessage);
    }

}
