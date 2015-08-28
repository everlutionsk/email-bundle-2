<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use Everlution\EmailBundle\Attachment\AttachmentLocator;
use Everlution\EmailBundle\Entity\StorableOutcomingMessage;
use Everlution\EmailBundle\Message\Outcoming\IdentifiableOutcomingMessage;
use Everlution\EmailBundle\Outbound\MailSystem;
use Everlution\EmailBundle\Message\Outcoming\OutcomingMessage;
use Everlution\EmailBundle\Message\Outcoming\ProcessedOutcomingMessage;
use Everlution\EmailBundle\Entity\Repository\StorableOutcomingMessage as StorableMessageRepository;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;

use Everlution\EmailBundle\Transformer\OutcomingMessageTransformer;

abstract class Mailer implements MailerInterface
{

    /** @var OutcomingMessageTransformer[] */
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
     * Mailer constructor.
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
     * @param OutcomingMessageTransformer[] $transformers
     */
    public function setMessageTransformers(array $transformers)
    {
        $this->messageTransformers = $transformers;
    }

    /**
     * @param OutcomingMessage $message
     * @return ProcessedOutcomingMessage
     */
    protected function processMessage(OutcomingMessage $message)
    {
        $message = $this->transformMessage($message);

        $identifiableMessage = $this->convertToIdentifiableMessage($message);
        $storableMessage = new StorableOutcomingMessage($identifiableMessage, $this->mailSystem->getMailSystemName());

        return new ProcessedOutcomingMessage($identifiableMessage, $storableMessage);
    }

    /**
     * @param OutcomingMessage $message
     * @return OutcomingMessage
     */
    protected function transformMessage(OutcomingMessage $message)
    {
        foreach ($this->messageTransformers as $transformer) {
            $message = $transformer->transform($message);
        }

        return $message;
    }

    /**
     * @param OutcomingMessage $message
     * @return IdentifiableOutcomingMessage
     */
    protected function convertToIdentifiableMessage(OutcomingMessage $message)
    {
        $newMessageId = $this->messageIdGenerator->generate();

        return new IdentifiableOutcomingMessage($newMessageId, $message);
    }

    /**
     * @param ProcessedOutcomingMessage $processedMessage
     */
    protected function storeProcessedMessage(ProcessedOutcomingMessage $processedMessage)
    {
        $this->storableMessageRepository->save($processedMessage->getStorableMessage());
        $this->storeAttachments($processedMessage);
    }

    /**
     * @param ProcessedOutcomingMessage $processedMessage
     */
    protected function storeAttachments(ProcessedOutcomingMessage $processedMessage)
    {
        $attachments = $processedMessage->getIdentifiableOutcomingMessage()->getMessage()->getAttachments();
        $this->attachmentLocator->saveAttachments($attachments, $processedMessage->getStorableMessage()->getId());
    }

}
