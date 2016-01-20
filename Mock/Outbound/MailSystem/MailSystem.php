<?php

namespace Everlution\EmailBundle\Mock\Outbound\MailSystem;

use DateTime;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystem as MailSystemInterface;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemException;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemMessageStatus;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemResult;
use Everlution\EmailBundle\Outbound\Message\UniqueOutboundMessage;
use Everlution\EmailBundle\Mock\Outbound\MailSystem\MailSystemResult as MailSystemResultMock;
use Everlution\EmailBundle\Support\UuidGenerator;

class MailSystem implements MailSystemInterface
{
    use UuidGenerator;

    /**
     * @param UniqueOutboundMessage $uniqueMessage
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function sendMessage(UniqueOutboundMessage $uniqueMessage)
    {
        return $this->mockResult($uniqueMessage, 'sent');
    }

    /**
     * @param UniqueOutboundMessage $uniqueMessage
     * @param DateTime $sendAt
     * @return MailSystemResult
     * @throws MailSystemException
     */
    public function scheduleMessage(UniqueOutboundMessage $uniqueMessage, DateTime $sendAt)
    {
        return $this->mockResult($uniqueMessage, 'scheduled');
    }

    /**
     * @param UniqueOutboundMessage $uniqueMessage
     * @param string $status
     * @return MailSystemResultMock
     */
    protected function mockResult(UniqueOutboundMessage $uniqueMessage, $status)
    {
        $messagesStatus = [];
        $recipients = $uniqueMessage->getMessage()->getRecipients();

        foreach ($recipients as $recipient) {
            $messagesStatus[] = new MailSystemMessageStatus($this->generateUUID(), $status, '', $recipient);
        }

        return new MailSystemResultMock($messagesStatus);
    }

    /**
     * @return string
     */
    public function getMailSystemName()
    {
        return 'mock';
    }

}
