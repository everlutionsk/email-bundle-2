<?php

namespace Everlution\EmailBundle\Relationship;

use Everlution\EmailBundle\Outbound\Message\OutboundMessage;

class MessageRelationshipManager
{

    const SUBJECT_PREFIX = 'Re: ';

    /**
     * @param OutboundMessage $message
     * @param ReplyableMessage $parentMessage
     */
    public function modifyToReplyMessage(OutboundMessage $message, ReplyableMessage $parentMessage)
    {
        $references = $parentMessage->getReferences() . ' ' . $parentMessage->getMessageId();

        $message->setReferences($references);
        $message->setInReplyTo($parentMessage->getMessageId());
        $message->setSubject(static::SUBJECT_PREFIX . $parentMessage->getSubject());
    }

}
