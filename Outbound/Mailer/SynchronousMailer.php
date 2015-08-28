<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Doctrine\Type\StorableOutcomingMessageStatus;
use Everlution\EmailBundle\Message\Outcoming\OutcomingMessage;
use Everlution\EmailBundle\Message\Outcoming\ProcessedOutcomingMessage as ProcessedMessage;
use Everlution\EmailBundle\Outbound\MailSystemException;

class SynchronousMailer extends Mailer
{

    /**
     * @param OutcomingMessage $message
     * @return ProcessedMessage
     */
    public function sendMessage(OutcomingMessage $message)
    {
        $processedMessage = $this->processMessage($message);

        $this->sendProcessedMessage($processedMessage);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

    /**
     * @param ProcessedMessage $processedMessage
     */
    protected function sendProcessedMessage(ProcessedMessage $processedMessage)
    {
        try {
            $this->mailSystem->sendMessage($processedMessage->getIdentifiableOutcomingMessage());
            $processedMessage->getStorableMessage()->setStatus(StorableOutcomingMessageStatus::SENT);
            $processedMessage->getStorableMessage()->setSentAt(new DateTime('now'));
        } catch (MailSystemException $e) {
            $this->handleMailSystemException($e, $processedMessage);
        }
    }

    /**
     * @param OutcomingMessage $message
     * @param DateTime $sendAt
     * @return ProcessedMessage
     */
    public function scheduleMessage(OutcomingMessage $message, DateTime $sendAt)
    {
        $processedMessage = $this->processMessage($message);

        $this->scheduleProcessedMessage($processedMessage, $sendAt);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

    /**
     * @param ProcessedMessage $processedMessage
     * @param DateTime $sendAt
     */
    protected function scheduleProcessedMessage(ProcessedMessage $processedMessage, DateTime $sendAt)
    {
        try {
            $this->mailSystem->scheduleMessage($processedMessage->getIdentifiableOutcomingMessage(), $sendAt);
            $processedMessage->getStorableMessage()->setStatus(StorableOutcomingMessageStatus::SCHEDULED);
        } catch (MailSystemException $e) {
            $this->handleMailSystemException($e, $processedMessage);
        }
    }

    /**
     * @param MailSystemException $exception
     * @param ProcessedMessage $processedMessage
     */
    protected function handleMailSystemException(MailSystemException $exception, ProcessedMessage $processedMessage)
    {
        $processedMessage->getStorableMessage()->setStatus(StorableOutcomingMessageStatus::FAILED);
        $processedMessage->getStorableMessage()->setError($exception->getMessage());
    }

}
