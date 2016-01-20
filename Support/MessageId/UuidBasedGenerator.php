<?php

namespace Everlution\EmailBundle\Support\MessageId;

use Everlution\EmailBundle\Support\UuidGenerator;

class UuidBasedGenerator implements Generator
{
    use UuidGenerator;

    /** @var string */
    protected $domainName;

    /**
     * @param string $domainName
     */
    public function __construct($domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * Generate valid Message-ID
     *
     * @return string
     */
    public function generate()
    {
        $uuid = $this->generateUUID();

        return "<$uuid@{$this->domainName}>";
    }

}
