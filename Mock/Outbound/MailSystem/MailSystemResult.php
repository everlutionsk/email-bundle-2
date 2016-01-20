<?php

namespace Everlution\EmailBundle\Mock\Outbound\MailSystem;

use Everlution\EmailBundle\Outbound\MailSystem\MailSystemMessageStatus;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemResult as MailSystemResultInterface;

class MailSystemResult implements MailSystemResultInterface
{

    /** @var MailSystemMessageStatus[] */
    protected $mailSystemMessagesStatus;

    /**
     * @param MailSystemMessageStatus[] $mailSystemMessagesStatus
     */
    public function __construct(array $mailSystemMessagesStatus)
    {
        $this->mailSystemMessagesStatus = $mailSystemMessagesStatus;
    }

    /**
     * @return MailSystemMessageStatus[]
     */
    public function getMailSystemMessagesStatus()
    {
        return $this->mailSystemMessagesStatus;
    }

}
