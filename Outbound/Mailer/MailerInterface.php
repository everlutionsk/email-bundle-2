<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\Outbound\ProcessedOutboundMessage;

interface MailerInterface
{

    /**
     * @param OutboundMessage $message
     * @return ProcessedOutboundMessage
     */
    public function sendMessage(OutboundMessage $message);

    /**
     * @param OutboundMessage $message
     * @param DateTime $sendAt
     * @return ProcessedOutboundMessage
     */
    public function scheduleMessage(OutboundMessage $message, DateTime $sendAt);

}
