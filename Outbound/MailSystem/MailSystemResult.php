<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

interface MailSystemResult
{

    /**
     * @return MailSystemMessageStatus[]
     */
    public function getMailSystemMessagesStatus();

}
