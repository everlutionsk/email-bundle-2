<?php

namespace Everlution\EmailBundle\Support\MessageId;

interface Generator
{

    /**
     * Generate valid Message-ID
     *
     * @return string
     */
    public function generate();

}
