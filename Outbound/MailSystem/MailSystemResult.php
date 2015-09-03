<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

class MailSystemResult
{

    /** @var MailSystemMessageInfo[] */
    protected $mailSystemMessagesInfo;

    /**
     * @param MailSystemMessageInfo[] $mailSystemMessagesInfo
     */
    public function __construct(array $mailSystemMessagesInfo)
    {
        $this->mailSystemMessagesInfo = $mailSystemMessagesInfo;
    }

    /**
     * @return MailSystemMessageInfo[]
     */
    public function getMailSystemMessagesInfo()
    {
        return $this->mailSystemMessagesInfo;
    }

}
