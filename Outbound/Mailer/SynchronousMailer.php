<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Doctrine\Type\StorableOutboundMessageStatus;
use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\Outbound\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystemException;
use Everlution\EmailBundle\Outbound\MailSystemResult;

class SynchronousMailer extends Mailer
{

    /**
     * @param OutboundMessage $message
     * @return ProcessedOutboundMessage
     */
    public function sendMessage(OutboundMessage $message)
    {
        $processedMessage = $this->processMessage($message);

        $this->sendProcessedMessage($processedMessage);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function sendProcessedMessage(ProcessedOutboundMessage $processedMessage)
    {
        try {
            $result = $this->mailSystem->sendMessage($processedMessage->getIdentifiableOutboundMessage());
            $this->handleMailSystemResult($result, $processedMessage);
         } catch (MailSystemException $e) {
            $this->handleMailSystemException($e, $processedMessage);
        }
    }

    /**
     * @param OutboundMessage $message
     * @param DateTime $sendAt
     * @return ProcessedOutboundMessage
     */
    public function scheduleMessage(OutboundMessage $message, DateTime $sendAt)
    {
        $processedMessage = $this->processMessage($message);

        $this->scheduleProcessedMessage($processedMessage, $sendAt);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

    /**
     * @param ProcessedOutboundMessage $processedMessage
     * @param DateTime $sendAt
     */
    protected function scheduleProcessedMessage(ProcessedOutboundMessage $processedMessage, DateTime $sendAt)
    {
        try {
            $result = $this->mailSystem->scheduleMessage($processedMessage->getIdentifiableOutboundMessage(), $sendAt);
            $this->handleMailSystemResult($result, $processedMessage);
        } catch (MailSystemException $e) {
            $this->handleMailSystemException($e, $processedMessage);
        }
    }

    /**
     * @param MailSystemResult $result
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function handleMailSystemResult(MailSystemResult $result, ProcessedOutboundMessage $processedMessage)
    {
        $processedMessage->getStorableMessage()->setStatus($result->getMessageStatus());
        $processedMessage->getStorableMessage()->setSentAt($result->getSentAt());
        $processedMessage->getStorableMessage()->setMailSystemMessageId($result->getMailSystemMessageId());
    }

    /**
     * @param MailSystemException $exception
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function handleMailSystemException(MailSystemException $exception, ProcessedOutboundMessage $processedMessage)
    {
        $processedMessage->getStorableMessage()->setStatus(StorableOutboundMessageStatus::FAILED);
        $processedMessage->getStorableMessage()->setError($exception->getMessage());
    }

}
