<?php

namespace Everlution\EmailBundle\Attachment;

interface Attachment
{

    /**
     * Returns the MIME type of the attachment
     * @return string
     */
    public function getMimeType();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getContent();

}
