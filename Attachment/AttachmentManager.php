<?php

namespace Everlution\EmailBundle\Attachment;

interface AttachmentManager
{

    /**
     * @param Attachment[] $attachments
     * @param mixed $storableMessage
     */
    public function saveAttachments(array $attachments, $storableMessage);

    /**
     * @param Attachment[] $images
     * @param mixed $storableMessage
     */
    public function saveImages(array $images, $storableMessage);

}
