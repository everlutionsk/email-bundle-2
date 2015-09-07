<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;
use Everlution\EmailBundle\Outbound\Message\ProcessedOutboundMessage;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemException;

interface MailerInterface
{

    /**
     * @param OutboundMessage $message
     * @return ProcessedOutboundMessage
     * @throws MailSystemException
     */
    public function sendMessage(OutboundMessage $message);

    /**
     * @param OutboundMessage $message
     * @param DateTime $sendAt
     * @return ProcessedOutboundMessage
     * @throws MailSystemException
     */
    public function scheduleMessage(OutboundMessage $message, DateTime $sendAt);

}
