<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Entity\StorableOutboundMessageInfo;
use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\Outbound\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemResult;

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
        $result = $this->mailSystem->sendMessage($processedMessage->getIdentifiableOutboundMessage());
        $this->handleMailSystemResult($result, $processedMessage);
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
        $result = $this->mailSystem->scheduleMessage($processedMessage->getIdentifiableOutboundMessage(), $sendAt);
        $this->handleMailSystemResult($result, $processedMessage);
    }

    /**
     * @param MailSystemResult $result
     * @param ProcessedOutboundMessage $processedMessage
     */
    protected function handleMailSystemResult(MailSystemResult $result, ProcessedOutboundMessage $processedMessage)
    {
        $storableMessage = $processedMessage->getStorableMessage();

        foreach ($result->getMailSystemMessagesInfo() as $mailSystemMessageInfo) {
            $storableMessage->addMessageInfo(new StorableOutboundMessageInfo($storableMessage, $mailSystemMessageInfo));
        }
    }

}
