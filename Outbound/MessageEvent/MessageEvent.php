<?php

namespace Everlution\EmailBundle\Outbound\MessageEvent;

class MessageEvent
{

    /** @var string */
    protected $mailSystemMessageId;

    /** @var string */
    protected $status;

    /** @var string */
    protected $reject_reason;

    /** @var string */
    protected $mailSystemName;

    /**
     * @param string $mailSystemMessageId
     * @param string $status
     * @param string $reject_reason
     * @param string $mailSystemName
     */
    public function __construct($mailSystemMessageId, $status, $reject_reason, $mailSystemName)
    {
        $this->mailSystemMessageId = $mailSystemMessageId;
        $this->status = $status;
        $this->reject_reason = $reject_reason;
        $this->mailSystemName = $mailSystemName;
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
        return $this->reject_reason;
    }

    /**
     * @return string
     */
    public function getMailSystemName()
    {
        return $this->mailSystemName;
    }

}
