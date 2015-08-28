<?php

namespace Everlution\EmailBundle\Recipient;

class BccRecipient extends Recipient
{

    /**
     * @return string
     */
    public function getType()
    {
        return 'bcc';
    }

}
