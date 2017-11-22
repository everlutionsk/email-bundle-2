<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Entity\StorableOutboundMessage;
use Everlution\EmailBundle\Entity\StorableOutboundMessageStatus;
use Everlution\EmailBundle\Outbound\Message\UniqueOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemException;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemResult;
use Everlution\EmailBundle\Support\MessageId\Generator as MessageIdGenerator;
use Everlution\EmailBundle\Outbound\Message\OutboundMessageTransformer;

abstract class Mailer implements MailerInterface
{

    /** @var OutboundMessageTransformer[] */
    protected $messageTransformers = [];

    /** @var MessageIdGenerator */
    protected $messageIdGenerator;

    /** @var MailSystem */
    protected $mailSystem;

    /**
     * @param MessageIdGenerator $messageIdGenerator
     * @param MailSystem $mailSystem
     */
    public function __construct(MessageIdGenerator $messageIdGenerator, MailSystem $mailSystem)
    {
        $this->messageIdGenerator = $messageIdGenerator;
        $this->mailSystem = $mailSystem;
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
     * @param DateTime|null $sendAt
     * @return ProcessedOutboundMessage
     */
    protected function processMessage(OutboundMessage $message, DateTime $sendAt = null)
    {
        $this->transformMessage($message);

        $uniqueMessage = $this->convertToUniqueMessage($message);
        $storableMessage = new StorableOutboundMessage($uniqueMessage, $this->mailSystem->getMailSystemName(), $sendAt);

        return new ProcessedOutboundMessage($uniqueMessage, $storableMessage);
    }

    /**
     * @param StorableOutboundMessage $storableMessage
     *
     * @return ProcessedOutboundMessage
     */
    protected function processMessageToResend(StorableOutboundMessage $storableMessage)
    {
        $message = $this->convertToOutboundMessage($storableMessage);
        $this->transformMessage($message);
        $uniqueMessage = new UniqueOutboundMessage($storableMessage->getMessageId(), $message);

        return new ProcessedOutboundMessage($uniqueMessage, $storableMessage);
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
     * @return UniqueOutboundMessage
     */
    protected function convertToUniqueMessage(OutboundMessage $message)
    {
        $newMessageId = $this->messageIdGenerator->generate();

        return new UniqueOutboundMessage($newMessageId, $message);
    }

    /**
     * @param StorableOutboundMessage $outboundMessage
     *
     * @return OutboundMessage
     */
    protected function convertToOutboundMessage(StorableOutboundMessage $outboundMessage)
    {
        return (new OutboundMessage())
            ->setSubject($outboundMessage->getSubject())
            ->setHtml($outboundMessage->getHtml())
            ->setRecipients($outboundMessage->getRecipients())
            ->setCustomHeaders($outboundMessage->getCustomHeaders());
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     * @throws MailSystemException
     */
    protected function sendProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $result = $this->mailSystem->sendMessage($processedMessage->getUniqueOutboundMessage());
        $this->updateMailSystemResult($result, $processedMessage);
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     * @throws MailSystemException
     */
    protected function scheduleProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $sendAt = $processedMessage->getStorableMessage()->getScheduledSendTime();
        $result = $this->mailSystem->scheduleMessage($processedMessage->getUniqueOutboundMessage(), $sendAt);

        $this->handleMailSystemResult($result, $processedMessage);
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     * @throws MailSystemException
     */
    protected function resendProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        $result = $this->mailSystem->resendMessage($processedMessage->getUniqueOutboundMessage());

        $this->updateMailSystemResult($result, $processedMessage);
    }

    /**
     * @param MailSystemResult $result
     * @param ProcessedOutboundMessage $processedMessage
     */
    abstract protected function handleMailSystemResult(MailSystemResult $result, ProcessedOutboundMessage $processedMessage);

    /**
     * @param MailSystemResult $result
     * @param ProcessedOutboundMessage $processedMessage
     */
    abstract protected function updateMailSystemResult(MailSystemResult $result, ProcessedOutboundMessage $processedMessage);
}
