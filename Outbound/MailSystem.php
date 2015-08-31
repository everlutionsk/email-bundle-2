<?php

namespace Everlution\EmailBundle\Outbound;

use DateTime;
use Everlution\EmailBundle\Message\Outbound\IdentifiableOutboundMessage;

interface MailSystem
{

    /**
     * @param IdentifiableOutboundMessage $identifiableMessage
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function sendMessage(IdentifiableOutboundMessage $identifiableMessage);

    /**
     * @param IdentifiableOutboundMessage $identifiableMessage
     * @param DateTime $sendAt
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function scheduleMessage(IdentifiableOutboundMessage $identifiableMessage, DateTime $sendAt);

    /**
     * @return string
     */
    public function getMailSystemName();

}
