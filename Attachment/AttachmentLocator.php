<?php

namespace Everlution\EmailBundle\Attachment;

interface AttachmentLocator
{

    /**
     * @param mixed $messageIdentifier
     * @return Attachment
     */
    public function findAttachments($messageIdentifier);

    /**
     * @param Attachment[] $attachments
     * @param mixed $messageIdentifier
     */
    public function saveAttachments(array $attachments, $messageIdentifier);

}
