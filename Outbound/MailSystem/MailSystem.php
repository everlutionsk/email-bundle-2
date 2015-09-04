<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

use DateTime;
use Everlution\EmailBundle\Message\Outbound\UniqueOutboundMessage;

interface MailSystem
{

    /**
     * @param UniqueOutboundMessage $identifiableMessage
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function sendMessage(UniqueOutboundMessage $identifiableMessage);

    /**
     * @param UniqueOutboundMessage $identifiableMessage
     * @param DateTime $sendAt
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function scheduleMessage(UniqueOutboundMessage $identifiableMessage, DateTime $sendAt);

    /**
     * @return string
     */
    public function getMailSystemName();

}
