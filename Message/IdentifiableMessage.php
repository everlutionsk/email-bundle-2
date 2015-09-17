<?php

namespace Everlution\EmailBundle\Message;

interface IdentifiableMessage
{

    /**
     * @return string
     */
    public function getMessageId();

}
