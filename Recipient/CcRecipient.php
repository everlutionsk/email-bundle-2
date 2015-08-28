<?php

namespace Everlution\EmailBundle\Recipient;

class CcRecipient extends Recipient
{

    /**
     * @return string
     */
    public function getType()
    {
        return 'cc';
    }

}
