<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use Everlution\EmailBundle\Attachment\AttachmentManager;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem;

abstract class StorableMessagesMailer extends Mailer
{

    /** @var StorableMessageRepository */
    protected $storableMessageRepository;

    /** @var AttachmentManager */
    protected $attachmentManager;

    /**
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentManager $attachmentManager
     */
    public function __construct(MessageIdGenerator $messageIdGenerator, MailSystem $mailSystem, StorableMessageRepository $storableMessageRepository, AttachmentManager $attachmentManager)
    {
        parent::__construct($messageIdGenerator, $mailSystem);
        $this->storableMessageRepository = $storableMessageRepository;
        $this->attachmentManager = $attachmentManager;
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function storeProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $this->storableMessageRepository->save($processedMessage->getStorableMessage());

        $this->storeAttachments($processedMessage);
        $this->storeImages($processedMessage);
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function storeAttachments(ProcessedOutboundMessage $processedMessage)
    {
        $attachments = $processedMessage->getUniqueOutboundMessage()->getMessage()->getAttachments();
        $storableMessage = $processedMessage->getStorableMessage();

        $this->attachmentManager->saveAttachments($attachments, $storableMessage);
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function storeImages(ProcessedOutboundMessage $processedMessage)
    {
        $attachments = $processedMessage->getUniqueOutboundMessage()->getMessage()->getImages();
        $storableMessage = $processedMessage->getStorableMessage();

        $this->attachmentManager->saveImages($attachments, $storableMessage);
    }

}
