<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Attachment\AttachmentLocator;
use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\Outbound\ProcessedOutboundMessage as ProcessedMessage;
use Everlution\EmailBundle\Outbound\MailSystem;
use Everlution\EmailBundle\Support\Stream\Stream;
use Everlution\EmailBundle\Entity\Repository\StorableOutboundMessage as StorableMessageRepository;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;

class AsynchronousMailer extends SynchronousMailer
{

    /** @var ProcessedMessage[] */
    protected $delayedMessages;

    /** @var array */
    protected $delayedSchedules;

    /**
     * @param Stream $asyncHandlingLauncher
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     * @param StorableMessageRepository $storableMessageRepository
     * @param AttachmentLocator $attachmentLocator
     */
    public function __construct(Stream $asyncHandlingLauncher, MessageIdGenerator $messageIdGenerator, MailSystem $mailSystem, StorableMessageRepository $storableMessageRepository, AttachmentLocator $attachmentLocator)
    {
        parent::__construct($messageIdGenerator, $mailSystem, $storableMessageRepository, $attachmentLocator);
        $this->handleStream($asyncHandlingLauncher);
    }

    /**
     * @param Stream $stream
     */
    protected function handleStream(Stream $stream)
    {
        $stream->listen(function($value) {
            $this->sendDelayedMessages();
            $this->sendScheduledMessages();
        });
    }

    protected function sendDelayedMessages()
    {
        foreach ($this->delayedMessages as $processedMessage) {
            $this->sendProcessedMessage($processedMessage);
            $this->storeProcessedMessage($processedMessage);
        }

        $this->delayedMessages = [];
    }

    protected function sendScheduledMessages()
    {
        foreach ($this->delayedSchedules as $schedule) {
            $this->scheduleProcessedMessage($schedule['message'], $schedule['sentAt']);
            $this->storeProcessedMessage($schedule['message']);
        }

        $this->delayedSchedules = [];
    }

    /**
     * @param OutboundMessage $message
     * @return ProcessedMessage
     */
    public function sendMessage(OutboundMessage $message)
    {
        $processedMessage = $this->processMessage($message);

        $this->delayedMessages[] = $processedMessage;

        return $processedMessage;
    }

    /**
     * @param OutboundMessage $message
     * @param DateTime $sendAt
     * @return ProcessedMessage
     */
    public function scheduleMessage(OutboundMessage $message, DateTime $sendAt)
    {
        $processedMessage = $this->processMessage($message);

        $this->delayedSchedules = [
            'sentAt' => $sendAt,
            'message' => $processedMessage
        ];

        return $processedMessage;
    }

}
