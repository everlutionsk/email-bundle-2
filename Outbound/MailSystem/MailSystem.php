<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

use DateTime;
use Everlution\EmailBundle\Outbound\Message\UniqueOutboundMessage;

interface MailSystem
{

    /**
     * @param UniqueOutboundMessage $uniqueMessage
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function sendMessage(UniqueOutboundMessage $uniqueMessage);

    /**
     * @param UniqueOutboundMessage $uniqueMessage
     * @param DateTime $sendAt
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function scheduleMessage(UniqueOutboundMessage $uniqueMessage, DateTime $sendAt);

    /**
     * @return string
     */
    public function getMailSystemName();

}
