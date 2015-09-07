<?php

namespace Everlution\EmailBundle\Message\Recipient;

class BccRecipient extends Recipient
{

    /**
     * @param string $email
     * @param string|null $name
     */
    public function __construct($email, $name = null)
    {
        parent::__construct($email, $name, 'bcc');
    }

}
