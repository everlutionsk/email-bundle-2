<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Attachment\AttachmentLocator;
use Everlution\EmailBundle\Entity\StorableOutboundMessage;
use Everlution\EmailBundle\Message\Outbound\IdentifiableOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem;
use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\Outbound\ProcessedOutboundMessage;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;
use Everlution\EmailBundle\Transformer\OutboundMessageTransformer;

abstract class Mailer implements MailerInterface
{

    /** @var OutboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var MessageIdGenerator */
    protected $messageIdGenerator;

    /** @var MailSystem */
    protected $mailSystem;

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentLocator */
    protected $attachmentLocator;

    /**
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentLocator $attachmentLocator
     */
    public function __construct(MessageIdGenerator $messageIdGenerator, MailSystem $mailSystem, StorableMessageRepository $storableMessageRepository, AttachmentLocator $attachmentLocator)
    {
        $this->messageIdGenerator = $messageIdGenerator;
        $this->mailSystem = $mailSystem;
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentLocator = $attachmentLocator;
    }

    /**
     * @param OutboundMessageTransformer $transformer
     */
    public function addMessageTransformer(OutboundMessageTransformer $transformer)
    {
        $this->messageTransformers[] = $transformer;
    }

    /**
     * @param OutboundMessage $message
     * @return ProcessedOutboundMessage
     */
    protected function processMessage(OutboundMessage $message)
    {
        $this->transformMessage($message);

        $identifiableMessage = $this->convertToIdentifiableMessage($message);
        $storableMessage = new StorableOutboundMessage($identifiableMessage, $this->mailSystem->getMailSystemName());

        return new ProcessedOutboundMessage($identifiableMessage, $storableMessage);
    }

    /**
     * @param OutboundMessage $message
     */
    protected function transformMessage(OutboundMessage $message)
    {
        foreach ($this->messageTransformers as $transformer) {
            $transformer->transform($message);
        }
    }

    /**
     * @param OutboundMessage $message
     * @return IdentifiableOutboundMessage
     */
    protected function convertToIdentifiableMessage(OutboundMessage $message)
    {
        $newMessageId = $this->messageIdGenerator->generate();

        return new IdentifiableOutboundMessage($newMessageId, $message);
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function storeProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $this->storableMessageRepository->save($processedMessage->getStorableMessage());

        $attachments = $processedMessage->getIdentifiableOutboundMessage()->getMessage()->getAttachments();
        $this->storeAttachments($attachments, $processedMessage->getStorableMessage());
    }

    /**
     * @param Attachment[] $attachments
     * @param StorableOutboundMessage $storableMessage
     */
    protected function storeAttachments(array $attachments, StorableOutboundMessage $storableMessage)
    {
        $this->attachmentLocator->saveAttachments($attachments, $storableMessage->getId());
    }

}
