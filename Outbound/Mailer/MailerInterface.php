<?php

namespace Everlution\EmailBundle\Outbound\Mailer;

use DateTime;
use Everlution\EmailBundle\Message\Outcoming\OutcomingMessage;
use Everlution\EmailBundle\Message\Outcoming\ProcessedOutcomingMessage;

interface MailerInterface
{

    /**
     * @param OutcomingMessage $message
     * @return ProcessedOutcomingMessage
     */
    public function sendMessage(OutcomingMessage $message);

    /**
     * @param OutcomingMessage $message
     * @param DateTime $sendAt
     * @return ProcessedOutcomingMessage
     */
    public function scheduleMessage(OutcomingMessage $message, DateTime $sendAt);

}
