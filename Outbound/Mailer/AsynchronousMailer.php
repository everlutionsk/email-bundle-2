<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Everlution\EmailBundle\Outbound\Attachment\AttachmentSwapper;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage as ProcessedMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem;
use Everlution\EmailBundle\Support\Stream\Stream;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;

class AsynchronousMailer extends StorableMessagesMailer
{

    /** @var ProcessedMessage[] */
    protected $delayedMessages = [];

    /** @var ProcessedMessage[] */
    protected $delayedSchedules = [];

    /**
     * @param Stream $asyncHandlingLauncher
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     * @param EntityManagerInterface $entityManager
     * @param AttachmentSwapper $attachmentSwapper
     */
    public function __construct(
        Stream $asyncHandlingLauncher,
        MessageIdGenerator $messageIdGenerator,
        MailSystem $mailSystem,
        EntityManagerInterface $entityManager,
        AttachmentSwapper $attachmentSwapper = null
    ) {
        parent::__construct($messageIdGenerator, $mailSystem, $entityManager, $attachmentSwapper);
        $this->registerStreamListener($asyncHandlingLauncher);
    }

    /**
     * @param OutboundMessage $message
     * @return ProcessedMessage
     */
    public function sendMessage(OutboundMessage $message)
    {
        $processedMessage = $this->processMessage($message);
        $this->storeProcessedMessage($processedMessage);

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
        $processedMessage = $this->processMessage($message, $sendAt);
        $this->storeProcessedMessage($processedMessage);

        $this->delayedSchedules[] = $processedMessage;

        return $processedMessage;
    }

    /**
     * @param Stream $stream
     */
    protected function registerStreamListener(Stream $stream)
    {
        $stream->listen(
            function ($value) {
                $this->sendDelayedMessages();
                $this->sendScheduledMessages();
            }
        );
    }

    protected function sendDelayedMessages()
    {
        foreach ($this->delayedMessages as $processedMessage) {
            $this->sendProcessedMessage($processedMessage);
        }

        $this->delayedMessages = [];
    }

    protected function sendScheduledMessages()
    {
        foreach ($this->delayedSchedules as $processedMessage) {
            $this->scheduleProcessedMessage($processedMessage);
        }

        $this->delayedSchedules = [];
    }

}
