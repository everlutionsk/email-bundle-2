<?php

namespace Everlution\EmailBundle\Support;

use Everlution\EmailBundle\Message\Outbound\OutboundMessage;
use Everlution\EmailBundle\Message\ReplyableMessage;

class ReplyManager
{

    const SUBJECT_PREFIX = 'Re: ';

    /**
     * @param OutboundMessage $message
     * @param ReplyableMessage $parentMessage
     */
    public function convertToReply(OutboundMessage $message, ReplyableMessage $parentMessage)
    {
        $references = $parentMessage->getReferences() . ' ' . $parentMessage->getMessageId();

        $message->setReferences($references);
        $message->setInReplyTo($parentMessage->getMessageId());
        $message->setSubject(static::SUBJECT_PREFIX . $parentMessage->getSubject());
    }

}
