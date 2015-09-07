<?php

namespace Everlution\EmailBundle\Relationship;

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

    /**
     * @return string
     */
    public function getSubject();

}
