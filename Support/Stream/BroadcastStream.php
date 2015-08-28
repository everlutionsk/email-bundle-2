<?php

namespace Everlution\EmailBundle\Support\Stream;

class BroadcastStream implements Stream
{

    /** @var callable[] */
    protected $onDataHandlers = [];

    /**
     * @param callable $onDataHandler
     */
    public function listen($onDataHandler)
    {
        if (!is_callable($onDataHandler)) {
            throw new \InvalidArgumentException('Cannot assign non-callable listener!');
        }

        $this->onDataHandlers[] = $onDataHandler;
    }

    /**
     * @param mixed $value
     */
    public function add($value)
    {
        $this->fire($value);
    }

    /**
     * Run registered listeners
     *
     * @param mixed $value
     */
    protected function fire($value)
    {
        foreach ($this->onDataHandlers as $onDataHandler) {
            $onDataHandler($value);
        }
    }

}
