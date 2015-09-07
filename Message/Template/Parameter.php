<?php

namespace Everlution\EmailBundle\Message\Template;

class Parameter
{

    /** @var string */
    protected $name;

    /** @var mixed */
    protected $value;

    /**
     * Parameter constructor.
     * @param string $name
     * @param mixed $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}
