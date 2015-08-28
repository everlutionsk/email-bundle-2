<?php

namespace Everlution\EmailBundle\Support\MessageId;

class UuidBasedGenerator implements Generator
{

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

    /**
     * @return string
     */
    protected function generateUUID()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
