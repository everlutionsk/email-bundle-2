<?php

namespace Everlution\EmailBundle\Outbound;

use DateTime;
use Everlution\EmailBundle\Message\Outcoming\IdentifiableOutcomingMessage;

interface MailSystem
{

    /**
     * @param IdentifiableOutcomingMessage $message
     * @throws MailSystemException
     */
    public function sendMessage(IdentifiableOutcomingMessage $message);

    /**
     * @param IdentifiableOutcomingMessage $message
     * @param DateTime $sendAt
     * @throws MailSystemException
     */
    public function scheduleMessage(IdentifiableOutcomingMessage $message, DateTime $sendAt);

    /**
     * @return string
     */
    public function getMailSystemName();

}
