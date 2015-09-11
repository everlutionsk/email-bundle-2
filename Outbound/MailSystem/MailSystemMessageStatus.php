<?php

namespace Everlution\EmailBundle\Outbound\MailSystem;

use Everlution\EmailBundle\Message\Recipient\Recipient;

class MailSystemMessageStatus
{

    /** @var string */
    protected $mailSystemMessageId;

    /** @var string */
    protected $status;

    /** @var string */
    protected $rejectReason;

    /** @var Recipient */
    protected $recipient;

    /**
     * @param string $mailSystemMessageId
     * @param string $status
     * @param string $rejectReason
     * @param Recipient $recipient
     */
    public function __construct($mailSystemMessageId, $status, $rejectReason, Recipient $recipient)
    {
        $this->mailSystemMessageId = $mailSystemMessageId;
        $this->status = $status;
        $this->rejectReason = $rejectReason;
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getMailSystemMessageId()
    {
        return $this->mailSystemMessageId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

}
