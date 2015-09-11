<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemException;

class SynchronousMailer extends StorableMessagesMailer
{

    /**
     * @param OutboundMessage $message
     * @return ProcessedOutboundMessage
     * @throws MailSystemException
     */
    public function sendMessage(OutboundMessage $message)
    {
        $processedMessage = $this->processMessage($message);

        $this->sendProcessedMessage($processedMessage);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

    /**
     * @param OutboundMessage $message
     * @param DateTime $sendAt
     * @return ProcessedOutboundMessage
     * @throws MailSystemException
     */
    public function scheduleMessage(OutboundMessage $message, DateTime $sendAt)
    {
        $processedMessage = $this->processMessage($message, $sendAt);

        $this->scheduleProcessedMessage($processedMessage);
        $this->storeProcessedMessage($processedMessage);

        return $processedMessage;
    }

}
