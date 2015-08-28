<?php

namespace Everlution\EmailBundle\Support\Stream;

interface Stream
{

    /**
     * @param callable $onDataHandler
     */
    public function listen($onDataHandler);

}
