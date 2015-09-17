<?php

namespace Everlution\EmailBundle\Relationship;

use Everlution\EmailBundle\Message\IdentifiableMessage;

interface ReplyableMessage extends IdentifiableMessage
{

    /**
     * @return string
     */
    public function getReferences();

    /**
     * @return string
     */
    public function getSubject();

}
