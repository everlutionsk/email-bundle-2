<?php

namespace Everlution\EmailBundle\Outbound;

use DateTime;

class MailSystemResult
{

    /** @var string */
    protected $messageStatus;

    /** @var string */
    protected $mailSystemMessageId;

    /** @var DateTime */
    protected $sentAt;

    /**
     * MailSystemResult constructor.
     * @param string $messageStatus
     * @param string $mailSystemMessageId
     * @param DateTime|null $sentAt
     */
    public function __construct($messageStatus, $mailSystemMessageId, DateTime $sentAt = null)
    {
        $this->messageStatus = $messageStatus;
        $this->mailSystemMessageId = $mailSystemMessageId;
        $this->sentAt = $sentAt;
    }

    /**
     * @return string
     */
    public function getMessageStatus()
    {
        return $this->messageStatus;
    }

    /**
     * @return string
     */
    public function getMailSystemMessageId()
    {
        return $this->mailSystemMessageId;
    }

    /**
     * @return DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

}
