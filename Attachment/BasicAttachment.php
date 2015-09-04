<?php

namespace Everlution\EmailBundle\Attachment;

class BasicAttachment implements Attachment
{

    /** @var string */
    protected $mimeType;

    /** @var string */
    protected $name;

    /** @var string */
    protected $content;

    /**
     * @param $mimeType
     * @param $name
     * @param $content
     */
    public function __construct($mimeType, $name, $content)
    {
        $this->mimeType = $mimeType;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Returns the MIME type of the attachment
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
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
    public function getContent()
    {
        return $this->content;
    }

}
