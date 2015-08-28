<?php

namespace Everlution\EmailBundle\Message;

interface ReplyableMessage
{

    /**
     * return $string
     */
    public function getMessageId();

    /**
     * @return string
     */
    public function getReferences();

}
