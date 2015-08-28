<?php

namespace Everlution\EmailBundle\Recipient;

abstract class Recipient
{

    /** @var string */
    protected $email;

    /** @var string */
    protected $name;

    /**
     * @param string $email
     * @param string|null $name
     */
    public function __construct($email, $name = null)
    {
        $this->email = $email;
        $this->name = $name;
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
    abstract public function getType();

}
