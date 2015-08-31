<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Attachment\AttachmentLocator;
use Everlution\EmailBundle\Entity\StorableInboundMessage;
use Everlution\EmailBundle\Entity\Repository\StorableInboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Message\Inbound\InboundMessage;
use Everlution\EmailBundle\Transformer\InboundMessageTransformer;

class InboundMessageProcessor implements InboundMessageProcessorInterface
{

    /** @var InboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentLocator */
    protected $attachmentLocator;

    /**
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentLocator $attachmentLocator
     */
    public function __construct(StorableMessageRepository $storableMessageRepository, AttachmentLocator $attachmentLocator)
    {
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentLocator = $attachmentLocator;
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
     * @param string $mailSystemName
     */
    public function storeInboundMessage(InboundMessage $message, $mailSystemName)
    {
        $this->transformMessage($message);

        $storableMessage = new StorableInboundMessage($message, $mailSystemName);

        $this->storeStorableMessage($storableMessage);
        $this->storeAttachments($message->getAttachments(), $storableMessage);
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
        $this->attachmentLocator->saveAttachments($attachments, $storableMessage->getId());
    }

}
