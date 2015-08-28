<?php

namespace Everlution\EmailBundle\Recipient;

class ToRecipient extends Recipient
{

    /**
     * @return string
     */
    public function getType()
    {
        return 'to';
    }

}
