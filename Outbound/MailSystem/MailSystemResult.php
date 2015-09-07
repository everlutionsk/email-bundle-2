<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

interface MailSystemResult
{

    /**
     * @return MailSystemMessageInfo[]
     */
    public function getMailSystemMessagesInfo();

}
