<?php

namespace Everlution\EmailBundle\Attachment;

interface AttachmentLocator
{

    /**
     * @param mixed $storableMessageIdentifier
     * @return Attachment
     */
    public function findAttachments($storableMessageIdentifier);

    /**
     * @param Attachment[] $attachments
     * @param mixed $storableMessageIdentifier
     */
    public function saveAttachments(array $attachments, $storableMessageIdentifier);

}
