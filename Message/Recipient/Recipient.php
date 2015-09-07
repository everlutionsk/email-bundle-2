<?php

namespace Everlution\EmailBundle\Message\Recipient;

class Recipient
{

    /** @var string */
    protected $email;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /**
     * @param string $email
     * @param string $name
     * @param string $type;
     */
    public function __construct($email, $name, $type)
    {
        $this->email = $email;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}
