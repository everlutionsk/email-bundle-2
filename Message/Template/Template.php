<?php

namespace Everlution\EmailBundle\Message\Template;

class Template
{

    /** @var string */
    protected $name;

    /** @var Parameter[] */
    protected $parameters;

    /**
     * @param string $name
     * @param Parameter[] $parameters
     */
    public function __construct($name, array $parameters)
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Parameter[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

}
