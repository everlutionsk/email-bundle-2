<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use Doctrine\ORM\EntityManagerInterface;
use Everlution\EmailBundle\Attachment\AttachmentManager;
use Everlution\EmailBundle\Entity\StorableOutboundMessageStatus;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemResult;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem;

abstract class StorableMessagesMailer extends Mailer
{

    /** @var AttachmentManager */
    protected $attachmentManager;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     * @param EntityManagerInterface $entityManager
     * @param AttachmentManager $attachmentManager
     */
    public function __construct(MessageIdGenerator $messageIdGenerator, MailSystem $mailSystem, EntityManagerInterface $entityManager, AttachmentManager $attachmentManager)
    {
        parent::__construct($messageIdGenerator, $mailSystem);
        $this->attachmentManager = $attachmentManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function storeProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $this->entityManager->persist($processedMessage->getStorableMessage());
        $this->entityManager->flush();

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

    /**
     * @param MailSystemResult $result
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function handleMailSystemResult(MailSystemResult $result, ProcessedOutboundMessage $processedMessage)
    {
        $storableMessage = $processedMessage->getStorableMessage();

        foreach ($result->getMailSystemMessagesStatus() as $mailSystemMessageStatus) {
            $messageStatus = new StorableOutboundMessageStatus($storableMessage, $mailSystemMessageStatus);
            $storableMessage->addMessageStatus($messageStatus);

            $this->entityManager->persist($messageStatus);
        }

        $this->entityManager->flush();
    }

}
